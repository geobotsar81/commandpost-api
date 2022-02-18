<?php

namespace App\Models;

use App\Models\User;
use App\Models\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Command extends Model
{
    use HasFactory;

    public $appends = ["formated_created"];

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ["command", "user_id", "collection_id", "description"];

    /**
     * The collection this command belongs to
     *
     * @return void
     */
    public function collection()
    {
        return $this->belongsTo(Collection::class);
    }

    /**
     * Generate a new attribute for a formated created date
     *
     * @return string
     */
    public function getFormatedCreatedAttribute(): string
    {
        $formated_date = \Carbon\Carbon::createFromTimeStamp(strtotime($this->created_at))->diffForHumans();
        return $formated_date;
    }

    /**
     * Sort by year
     *
     * @param [type] $query
     * @return Builder
     */
    public function scopeSortByDate($query): Builder
    {
        return $query->orderBy("created_at", "desc");
    }
}
