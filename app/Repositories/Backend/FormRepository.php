<?php

namespace App\Repositories\Backend;

use App\Models\FormsAnswered;
use App\Models\FormsAnswerOptions;
use App\Models\FormsAnswers;
use jazmy\FormBuilder\Models\Submission;
use App\Repositories\BaseRepository;
use \Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use jazmy\FormBuilder\Events\Form\FormCreated;
use jazmy\FormBuilder\Events\Form\FormDeleted;
use jazmy\FormBuilder\Events\Form\FormUpdated;
use jazmy\FormBuilder\Helper;
use jazmy\FormBuilder\Models\Form;
use jazmy\FormBuilder\Requests\SaveFormRequest;
use App\Models\Question;
use App\Models\QuestionImages;
use App\Models\QuestionOption;
use App\Models\SkipCondition;
use App\Models\QuestionType;

/**
 * Class FormRepository
 * @package App\Repositories\Backend
 * @version December 2, 2019, 8:48 am UTC
*/

class FormRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'name',
        'visibility',
        'allows_edit',
        'identifier',
        'form_builder_json',
        'timestamp',
        'mocked',
        'accuracy',
        'long',
        'lat',
        'custom_submit_url'
    ];

    public function __construct(Form $model)
    {
        $this->model = $model;
    }

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function create(array $data)
    {
        $structure_id = Auth::guard('api')->user()->logged_structure_id;
        if($structure_id==null){
            $structure_id = Auth::guard('api')->user()->structure_id;
        }
        $user_id = Auth::guard('api')->user()->id;
        \Log::debug($data);

        if ($this->FormExists($data['formname'], $structure_id)) {
            throw new \Exception('A form already exists with the name '.e($data['formname']));
        }

        $input=[
            'user_id' => $user_id,
            'structure_id' => $structure_id,
            'name' => $data['formname'],
            'form_category_id' => $data['form_category_id'],
            'visibility' => "public",
            'form_builder_json' => json_encode($data['formobj']),
        ];


        DB::beginTransaction();

        $input['identifier'] = $user_id.'-'.Helper::randomString(20);
        $created = Form::create($input);

        $form_id = $created->id;

        $form_questions = $data['formobj'];
        foreach($form_questions as $question){
            $question_created = Question::create([
                "form_id" => $form_id,
                "type" => $question['type'],
                "required" => $question['required'],
                "label" => $question['label'],
                "name" => $question['name'],
                "subtype" => isset($question['subtype']) ? $question['subtype'] : null,
                "type" => $question['type'],
                "desc" => $question['label'],
                "className" => isset($question['className']) ? $question['className'] : null,
                "access" => isset($question['access']) ? $question['access'] : null
            ]);

            if(isset($question['values'])){
                foreach($question['values'] as $value){
                    $questionoption = QuestionOption::create([
                        "question_id" => $question_created->id,
                        "label" => $value['label'],
                        "value" => $value['value'],
                        "selected" => isset($value['selected']) ? $value['selected'] : null
                    ]);
                }
            }
        }

        try {
            // dispatch the event
            event(new FormCreated($created));

            DB::commit();

            return $created;

        } catch (\Throwable $e) {
            info($e);

            DB::rollback();

            return response()->json(['success' => false, 'details' => 'Failed to create the form.']);
        }
    }
    public function createCustom(array $data)
    {
        $structure_id = Auth::guard('api')->user()->logged_structure_id;
        if($structure_id==null){
            $structure_id = Auth::guard('api')->user()->structure_id;
        }
        $user_id = Auth::guard('api')->user()->id;
        \Log::debug($data);

        // if ($this->FormExists($data['formname'], $structure_id)) {
        //     throw new \Exception('A form already exists with the name '.e($data['formname']));
        // }

        $input=[
            'user_id' => $user_id,
            'structure_id' => $structure_id,
            'name' => $data['formname'],
            'form_category_id' => $data['form_category_id'],
            'visibility' => "public",
            'form_builder_json' => json_encode($data['formobj']),
        ];


        DB::beginTransaction();

        $input['identifier'] = $user_id.'-'.Helper::randomString(20);
        $created = Form::create($input);

        $form_id = $created->id;
        $question_ids = [];

        $form_questions = $data['formobj'];
        foreach($form_questions as $question){
            $QuestionType = QuestionType::find($question['question_type']);
            $question_created = Question::create([
                "form_id" => $form_id,
                "type" => $QuestionType->question_type,
                "question_type_id" => $question['question_type'],
                "required" => $question['required'],
                "label" => $question['label'],
                "skip"=> $question['has_skip'],
                "name" => $question['label'],
                "desc" => $question['label'],
            ]);
            $question_arr = ['question_id' => $question_created->id, 'question_form_id' => $question['question_id']];
            $question_ids[] = $question_arr;

            if(isset($question['options'])){
                foreach($question['options'] as $value){
                    $questionoption = QuestionOption::create([
                        "question_id" => $question_created->id,
                        "label" => $value['option'],
                        "value" => $value['id'],
                    ]);
                }
            }
            if($question['has_skip']&&isset($question['skip_conditions'])){
                foreach($question['skip_conditions'] as $value){
                    foreach ($question_ids as $key => $question_ids_arr) {
                        # code...
                        if($question_ids_arr['question_form_id'] == $value['question']){
                            $selected_question_id = $question_ids_arr['question_id'];
                        }
                    }
                    $skip_condition = SkipCondition::create([
                        "question_id" => $question_created->id,
                        "skip_option_id" => $value['skip_option'],
                        "selected_question_id" => $selected_question_id,
                    ]);
                }
            }
        }

        try {
            // dispatch the event
            event(new FormCreated($created));

            DB::commit();

            return $created;

        } catch (\Throwable $e) {
            info($e);

            DB::rollback();

            return response()->json(['success' => false, 'details' => 'Failed to create the form.']);
        }
    }
    public function createApi(array $data, $uploadedFiles)
    {
        \Log::debug($data);
        $identifier = $data['identifier'];
        $form = Form::where('identifier', $data['identifier'])->firstOrFail();

        DB::beginTransaction();

        try {
            $input=[];
            $inputdata = json_decode($data['formdata']);
            foreach ($inputdata as $key => $inputval) {
                $input[$inputval->name] = $inputval->value;
            }
            // check if files were uploaded and process them
            $photo_paths = [];
            $filenamesindividual = json_decode($data['filenamesindividual']);
            $filenamesextra = json_decode($data['filenamesextra']);
            foreach ($uploadedFiles as $key => $file) {
                // store the file and set it's path to the value of the key holding it
                if(in_array($key, $filenamesindividual)){
                    if ($file->isValid()) {
                        $input[$key] = $file->store('merchandizing', 'public');
                    }
                }
            }

            $position = json_decode($data['position']);
            $user_id = auth('api')->user()->id ?? null;
            $date = \Carbon\Carbon::createFromTimestamp($position->timestamp/1000)->toDateTimeString();
            \Log::debug($input);

            \Log::debug($position->timestamp);
            $formsubission = $form->submissions()->create([
                'user_id' => $user_id,
                'content' => $input,
            ]);

            $start  = \Carbon\Carbon::createFromTimestamp($data['starttimestamp']/1000);
            $end    = \Carbon\Carbon::createFromTimestamp($data['submittimestamp']/1000);
            \Log::debug($start);
            \Log::debug($end);
            $diff = $start->diff($end)->format('%H:%I:%S');
            \Log::debug($diff);
            \Log::debug($form->id);
            $formsanswered = FormsAnswered::create([
                'user_id' => $user_id,
                'form_id' => $form->id,
                'customer_id'=> $data['cust_id'],
                'sub_customer_id'=> $data['sub_customer_id'],
                'status_id' => 3,
                'has_answers' => true,
                'start' => $start,
                'end' => $end,
                'duration' => $diff,
                'lat' => $position->coords->latitude,
                'long' => $position->coords->longitude,
                'accuracy' => $position->coords->accuracy,
                'mocked' => $position->mocked,
                'geotimestamp'=> $date,
                'content' => $input,
            ]);

            $formsansweredid = $formsanswered->id;

            foreach ($inputdata as $key => $inputval) {
                $question = Question::where('name', $inputval->name)->firstOrFail();
                if(isset($inputval->type)&&$inputval->type=="checkbox-group"){
                    $question_input = [
                        'form_answered_id' => $formsansweredid,
                        'question_id' => $question->id,
                        'question_type' => $question->type,
                        'answer' => "multiple",
                        'target' => isset($inputval->targetvar) ? $inputval->targetvar : null,
                    ];

                    $question_answered = FormsAnswers::create($question_input);
                    foreach($inputval->value as $option){
                        $questionoption = FormsAnswerOptions::create([
                            'form_answer_id' => $question_answered->id,
                            'question_id' => $question->id,
                            'question_type' => $question->type,
                            'answer' => $option
                        ]);
                    }
                    $imagecount = $inputval->imagecount;
                    \Log::debug($imagecount);
                    $i=0;

                    while($i<$imagecount){

                        $photoname = $inputval->name."_photo".$i;
                        \Log::debug($filenamesextra);

                            $file = $uploadedFiles[$photoname];

                            if ($file->isValid()) {
                                $imageurl = $file->store('merchandizing', 'public');
                                \Log::debug($imageurl);

                                $question_image = QuestionImages::create([
                                    'form_answer_id' => $question_answered->id,
                                    'question_id' => $question->id,
                                    'question_type' => $question->type,
                                    'img_url' => $imageurl
                                ]);
                                \Log::debug($question_image);

                        }
                        $i++;

                    }

                }else{
                    $question_input = [
                        'form_answered_id' => $formsansweredid,
                        'question_id' => $question->id,
                        'question_type' => $question->type,
                        'answer' => $inputval->value,
                        'target' => isset($inputval->targetvar) ? $inputval->targetvar : null,
                    ];
                    $question_answered = FormsAnswers::create($question_input);
                    $imagecount = $inputval->imagecount;
                    $i=0;
                    while($i<$imagecount){
                        $photoname = $inputval->name."_photo".$i;

                            $file = $uploadedFiles[$photoname];
                            if ($file->isValid()) {
                                $imageurl = $file->store('merchandizing', 'public');
                                QuestionImages::create([
                                    'form_answer_id' => $question_answered->id,
                                    'question_id' => $question->id,
                                    'question_type' => $question->type,
                                    'img_url' => $imageurl
                                ]);
                            }

                        $i++;
                    }
                }

            }

            DB::commit();

            return $form;
        } catch (\Throwable $e) {
            \Log::debug($e);

            DB::rollback();

            abort(422, 'An error occured attempting to create submission');
        }
    }

    protected function FormExists($name, $structure_id) : bool
    {
            return $this->model
                ->where('name', strtolower($name))
                ->where('structure_id', strtolower($structure_id))
                ->count() > 0;
    }
    public function find($id) : Form
    {
            return $this->model->find($id);
    }
    public function delete($id)
    {
            $model = $this->model->find($id);
            return $this->model->delete();
     }
}
