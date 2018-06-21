<?php

namespace App\Repositories;

use App\Models\Address;
use App\Models\BusinessTransfer;
use App\Models\Court;
use App\Models\FirstApartment;
use App\Models\SecondApartment;
use App\Models\Shop;
use App\Models\User;
use App\Models\WorkshopLand;
use App\Models\Appointment;

class InfoRepository
{
    /**
     * @var FirstApartment
     */
    private $firstApartment;

    /**
     * @var SecondApartment
     */
    private $secondApartment;

    protected $apartment;

    /**
     * @var Court
     */
    private $court;

    /**
     * @var Address
     */
    private $address;

    /**
     * @var Shop
     */
    private $shop;

    /**
     * @var BusinessTransfer
     */
    private $businessTransfer;

    /**
     * @var WorkshopLand
     */
    private $workshopLand;

    /**
     * @var User
     */
    private $user;

    public function __construct(FirstApartment $firstApartment, SecondApartment $secondApartment, Court $court, Address $address, Shop $shop, BusinessTransfer $businessTransfer, WorkshopLand $workshopLand, User $user) {
        $this->firstApartment = $firstApartment;
        $this->secondApartment = $secondApartment;
        $this->court = $court;
        $this->address = $address;
        $this->shop = $shop;
        $this->businessTransfer = $businessTransfer;
        $this->workshopLand = $workshopLand;
        $this->user = $user;
    }

    public function getBySecondApartment($id) {
        return $this->secondApartment->with(['images', 'court', 'agent', 'user'])->findOrFail($id);
    }

    public function getByShop($id) {
        return $this->shop->with(['images', 'court', 'agent', 'user'])->findOrFail($id);
    }

    public function getByFirstApartment($id) {
        return $this->firstApartment->with(['images', 'court', 'agent'])->findOrFail($id);
    }

    public function getByBusinessTransfer($id) {
        return $this->businessTransfer->with(['images', 'court', 'agent', 'user'])->findOrFail($id);
    }

    public function getByWorkShopLand($id) {
        return $this->workshopLand->with(['images', 'court', 'agent', 'user'])->findOrFail($id);
    }

    public function getByAbouts($id, $self, $relation, $type = null) {
        $result = $this->court->findOrFail($id)->$relation()->with('images')->where('id', '<>', $self);

        $type && $result = $result->where('sale_or_rental', $type)->where('status', 1)->where('save_or_output',1);

        $result = $result->take(5)->get();

        return $result;
    }

    public function getByArea($id) {
        return $this->address->findOrFail($id)->zonename;
    }

    public function esfFollow($data) {
        $related = 'esfs';

        return $this->following($data, $related);
    }

    public function shopFollow($data) {
        $related = 'shops';

        return $this->following($data, $related);
    }

    public function ysfFollow($data) {
        $related = 'ysfs';

        return $this->following($data, $related);
    }

    public function businessTransferFollow($data) {
        $related = 'businessTransfers';

        return $this->following($data, $related);
    }

    public function workshopLandFollow($data) {
        $related = 'workshopLand';

        return $this->following($data, $related);
    }

    public function isFollow($data, $related) {
        return $this->user->findOrFail($data->uid)->$related()->find($data->rid) ? true : false;
    }

    public function follow($data, $related) {
        return $this->user->findOrFail($data->uid)->$related()->detach($data->rid);
    }

    public function notFollow($data, $related) {
        return $this->user->findOrFail($data->uid)->$related()->attach($data->rid);
    }

    /**
     * @param $data
     * @param $related
     *
     * @return bool
     */
    public function following($data, $related) {
        $related .= 'Follow';
        $follow = $this->isFollow($data, $related);
        if ($data->has('check')) {
            $follow ? $this->follow($data, $related) : $this->notFollow($data, $related);
            $follow = !$follow;
        }

        return $follow;
    }

    public function appointment($data, $related) {

        $related .= 'Appointment';
        $isAppointment = $this->isAppointment($data, $related);

        if (!$isAppointment) {
            if ($data->has('check')) {
                $this->user->findOrFail($data->uid)->$related()->attach($data->rid, ['created_at' => date("Y-m-d H:i:s",time())]);

                $isAppointment = !$isAppointment;
            }
        }

        return $isAppointment;
    }

    public function checkC($data) {
        $count = SecondApartment::where([
            ['court_id', '=', $data['court_id']],
            ['building', '=', $data['building']],
            ['unit', '=', $data['unit']],
            ['room', '=', $data['room']],
        ])->count();
        return $count == 0;
    }

    /**
     * @param $data
     * @param $related
     */
    public function isAppointment($data, $related) {
        return $this->user->findOrFail($data->uid)->$related()->find($data->rid) ? true : false;
    }

    /**
     * 浏览次数递增
     *
     * @param $id id
     * @param $type 类型
     */
    public function increasesHits($id, $type) {
        $type -> find($id) -> increment('hits');
    }
}