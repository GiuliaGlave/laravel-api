<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Project extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'slug', 'thumbnail', 'details', 'type_id'];
    
  /*   protected $with = ['type','technologies']; */

    public function getPlaceholder(){
        return $this->thumbnail ? asset('storage/' . $this->thumbnail) : "https://blumagnolia.ch/wp-content/uploads/2021/05/placeholder-126.png";
    }
    public function getAbstract($max = 150){
        return substr($this->details, 0, $max) . "[...]";
    }
    public function getAbstractIndex($max = 50){
        return substr($this->details, 0, $max) . "...";
    }
    public static function getSlug($title){
        //genero il primo slug
        $new_slug = Str::of($title)->slug('-');  
        //controllo se il primo slug è già nel database
        $projects = Project::where('slug', $new_slug)->get();
        
        $original_slug = $new_slug;
        $i = 2;

        while(count($projects)){
            $new_slug =$original_slug . '-' . $i;
            $projects = Project::where('slug', $new_slug)->get();
            $i++;
        }
        return $new_slug;
    }



    //Relazioni
    public function type() {
        return $this->belongsTo(Type::class);
    }

    public function technologies()
    {
        return $this->belongsToMany(Technology::class);
    }
}