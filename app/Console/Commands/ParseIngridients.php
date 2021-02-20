<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Services\CsvParser;
use App\Models\Ingridient;
use App\Models\Rating;
use Illuminate\Console\Command;

class ParseIngridients extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:csv';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse ingridients';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $parser = new CsvParser();

        $csvFileName = "ingridients.csv";
        $csvFile = public_path('csv/' . $csvFileName);
        $lines = $parser->readCSV($csvFile,array('delimiter' => ','));

        foreach ($lines as $line) {
            $ingridient = new Ingridient();
            if (!empty($line[0])) {
                $blob = explode("\n", $line[0]);

                $ingridient->title = $blob[0];

                $description = strpos($blob[1], 'Categories: ') !== false ? '' : $blob[1];
                $ingridient->description = $description;

                // parse rating
                $rating = Rating::where('title', trim($line[1]))->first();
                if (!$rating) {
                    $ratingModel = new Rating();
                    $ratingModel->title = trim($line[1]);
                    $ratingModel->save();
                    $ratingId = $ratingModel->id;
                } else {
                    $ratingId = $rating->id;
                }
                $ingridient->rating_id = $ratingId;

                $ingridient->source = $line[2];
                $ingridient->save();

                // parse category
                if (!empty($blob[2])) {
                    $strCategories = str_replace('Categories: ', '', $blob[2]);

                    $categories = explode(',', $strCategories);

                    foreach ($categories as $item) {
                        $category = Category::where('title', trim($item))->first();
                        if (!$category) {
                            $categoryModel = new Category();
                            $categoryModel->title = trim($item);
                            $categoryModel->save();
                            $categoryId = $categoryModel->id;
                        } else {
                            $categoryId = $category->id;
                        }
                        $ingridient->categories()->attach($categoryId);
                    }
                } else if (!empty($blob[1]) && strpos($blob[1], 'Categories: ') !== false) {
                    $strCategories = str_replace('Categories: ', '', $blob[1]);

                    $categories = explode(',', $strCategories);

                    foreach ($categories as $item) {
                        $category = Category::where('title', trim($item))->first();
                        if (!$category) {
                            $categoryModel = new Category();
                            $categoryModel->title = trim($item);
                            $categoryModel->save();
                            $categoryId = $categoryModel->id;
                        } else {
                            $categoryId = $category->id;
                        }
                        $ingridient->categories()->attach($categoryId);
                    }
                }

                var_dump("Saved ingridient " . $ingridient->title);
            }
        }
    }
}


