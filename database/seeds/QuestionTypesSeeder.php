<?php

use App\Models\QuestionType;
use Illuminate\Database\Seeder;

/**
 * Class UserTableSeeder.
 */
class QuestionTypesSeeder extends Seeder
{
    use DisableForeignKeys;

    /**
     * Run the database seed.
     */
    public function run()
    {
        $this->disableForeignKeys();
        QuestionType::truncate();
        // Add the master administrator, user id of 1
        QuestionType::create([
            'question_type' => 'text'
        ]);
        QuestionType::create([
            'question_type' => 'select'
        ]);
        // QuestionType::create([
        //     'question_type' => 'select_many'
        // ]);
        QuestionType::create([
            'question_type' => 'radio'
        ]);
        QuestionType::create([
            'question_type' => 'checkbox'
        ]);
        QuestionType::create([
            'question_type' => 'date'
        ]);
        QuestionType::create([
            'question_type' => 'photo'
        ]);
        QuestionType::create([
            'question_type' => 'numeric'
        ]);

        $this->enableForeignKeys();
    }
}
