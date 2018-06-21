<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use SoftDeletes;
    use Notifiable,HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pid', 'mobile', 'name', 'id_card', 'avatar', 'is_agent', 'score', 'balance', 'frozen', 'password','news','admin_agent'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /*
     * Follow 结尾为我关注
     * Appointment 结尾为我预约
     * Owner 结尾为我发布
     * Agent 结尾为他人预约我
     */

    public function esfsFollow() {
        return $this->morphedByMany('App\Models\SecondApartment', 'favorable', 'favorites');
    }

    public function esfsAppointment() {
        return $this->morphedByMany('App\Models\SecondApartment', 'appointmentable', 'appointments')->withPivot('status');
    }

    public function esfsOwner() {
        return $this->hasMany('App\Models\SecondApartment');
    }

    public function esfsAgent() {
        return $this->hasMany('App\Models\SecondApartment', 'agent_id')->orderBy('created_at','DESC');
    }

    public function shopsFollow() {
        return $this->morphedByMany('App\Models\Shop', 'favorable', 'favorites');
    }

    public function shopsAppointment() {
        return $this->morphedByMany('App\Models\Shop', 'appointmentable', 'appointments')->withPivot('status');
    }

    public function shopsOwner() {
        return $this->hasMany('App\Models\Shop');
    }

    public function shopsAgent() {
        return $this->hasMany('App\Models\Shop', 'agent_id');
    }

    public function ysfsFollow() {
        return $this->morphedByMany('App\Models\FirstApartment', 'favorable', 'favorites');
    }

    public function ysfsAppointment() {
        return $this->morphedByMany('App\Models\FirstApartment', 'appointmentable', 'appointments')->withPivot('status');
    }

    public function businessTransfersFollow() {
        return $this->morphedByMany('App\Models\BusinessTransfer', 'favorable', 'favorites');
    }

    public function businessTransfersAppointment() {
        return $this->morphedByMany('App\Models\BusinessTransfer', 'appointmentable', 'appointments')->withPivot('status');
    }

    public function businessTransfersOwner() {
        return $this->hasMany('App\Models\BusinessTransfer');
    }

    public function businessTransfersAgent() {
        return $this->hasMany('App\Models\BusinessTransfer', 'agent_id');
    }

    public function workshopLandsFollow() {
        return $this->morphedByMany('App\Models\WorkshopLand', 'favorable', 'favorites');
    }

    public function workshopLandsAppointment() {
        return $this->morphedByMany('App\Models\WorkshopLand', 'appointmentable', 'appointments')->withPivot('status');
    }

    public function workshopLandsOwner() {
        return $this->hasMany('App\Models\WorkshopLand');
    }

    public function workshopLandsAgent() {
        return $this->hasMany('App\Models\WorkshopLand', 'agent_id');
    }

    public function workshopRendsAgent() {
        return $this->hasMany('App\Models\WorkshopLand', 'agent_id');
    }

    public function agentsComments() {
        return $this->belongsToMany('App\Models\User', 'comments', 'agent_id')
            ->withTimestamps()
            ->withPivot('source', 'tags')->orderBy('created_at','asc');
    }


}
