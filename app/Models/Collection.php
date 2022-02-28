<?php

namespace App\Models;

use App\Models\User;
use Hashids\Hashids;
use App\Models\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Collection extends Model
{
    use HasFactory;

    public $appends = ["formated_created", "encrypted_id"];

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ["title", "user_id", "order", "views"];

    /**
     * The user this collection belongs to
     *
     * @return void
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The commands this collection has
     *
     * @return void
     */
    public function commands()
    {
        return $this->hasMany(Command::class);
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
     * Generate a uuid
     *
     * @return string
     */
    public function getEncryptedIdAttribute(): string
    {
        $hashids = new Hashids("", 10);
        return $hashids->encode($this->id);
    }
}
