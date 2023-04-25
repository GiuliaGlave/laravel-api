<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'slug', 'thumbnail', 'details', 'type_id'];
    
  /*   protected $with = ['type','technologies']; */

    public function getPlaceholder(){
        return $this->thumbnail ? asset('storage/' . $this->thumbnail) : "https://blumagnolia.ch/wp-content/uploads/2021/05/placeholder-126.png";
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