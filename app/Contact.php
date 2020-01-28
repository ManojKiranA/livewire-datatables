<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $guarded = [];

    protected $casts = ['birthdate' => 'date','last_contacted_at' =>'date'];

    public static function search($query)
    {
        return empty($query) ? static::query()
            : static::where('name', 'like', '%'.$query.'%')
                ->orWhere('email', 'like', '%'.$query.'%');
    }

    public  function highlightStringInParagraph(string $paragraphText='', $highlightWords='',$highlightColor='red')
    {
        
        if (is_array($highlightWords)) 
        {
            foreach($highlightWords as $highlightWord)
            {
                $paragraphText = preg_replace(
                    "|($highlightWord)|Ui" ,
                    "<span style=\"color:".$highlightColor. ";\"><b>$1</b></span>" ,
                    $paragraphText 
                );
            }
        }
        elseif (!is_array($highlightWords)) 
        {
           
            $paragraphText = preg_replace(
                    "|($highlightWords)|Ui" ,
                    "<span style=\"color:".$highlightColor. ";\"><b>$1</b></span>" ,
                    $paragraphText 
                );
        }
        return $paragraphText;
    }

    /**
     * The number of models to return for pagination.
     *
     * @var int
     */
    protected $perPage = 5;
}
