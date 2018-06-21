<?php

namespace App\Repositories;

use App\Models\BrokerTag;
use App\Models\User;
use App\Models\Appointment;

class UserCenterRepository
{
    /**
     * @var User
     */
    private $user;

    /**
     * @var BrokerTag
     */
    private $brokerTag;

    /**
     * UserCenterRepository constructor.
     *
     * @param User             $user
     * @param BrokerTag        $brokerTag
     *
     * @param Comment          $comment
     *
     * @param BrokerTagComment $brokerTagComment
     *
     * @internal param AddressRepository $addressRepository
     */
    public function __construct(User $user, BrokerTag $brokerTag ,Appointment $appointment) {

        $this->user = $user;
        $this->appointment = $appointment;
        $this->brokerTag = $brokerTag;
    }

    public function esfSaleFollowList($data) {
        return $this->user->findOrFail(\Auth::user()->id)->esfsFollow()->with([
            'images',
            'court'
        ])->where(['sale_or_rental' => 'sale', 'status' => STATUS_PASS])->paginate($data->page)->toArray();
    }

    public function esfSaleOwnerList($data) {

            return $this->user->findOrFail(\Auth::user()->id)->esfsOwner()->with([
                'images',
                'court'
            ])->where(['sale_or_rental' => 'sale'])->where(['status' => '1'])->paginate(10)->toArray();
    }

    public function esfRentalFollowList($data) {
        return $this->user->findOrFail(\Auth::user()->id)->esfsFollow()->with([
            'images',
            'court'
        ])->where(['sale_or_rental' => 'rental', 'status' => STATUS_PASS])->paginate($data->page)->toArray();
    }

    public function esfRentalOwnerList($data) {
        return $this->user->findOrFail(\Auth::user()->id)->esfsOwner()->with([
            'images',
            'court'
        ])->where(['sale_or_rental' => 'rental'])->paginate(10)->toArray();
    }

    public function shopSaleFollowList($data) {
        return $this->user->findOrFail(\Auth::user()->id)->shopsFollow()->with([
            'images',
            'court'
        ])->where(['sale_or_rental' => 'sale', 'status' => STATUS_PASS])->paginate($data->page)->toArray();
    }

    public function shopSaleOwnerList($data) {
        return $this->user->findOrFail(\Auth::user()->id)->shopsOwner()->with([
            'images',
            'court'
        ])->where(['sale_or_rental' => 'sale', 'status' => STATUS_PASS])->paginate(10)->toArray();
    }

    public function shopRentalFollowList($data) {
        return $this->user->findOrFail(\Auth::user()->id)->shopsFollow()->with([
            'images',
            'court'
        ])->where(['sale_or_rental' => 'rental', 'status' => STATUS_PASS])->paginate($data->page)->toArray();
    }

    public function shopRentalOwnerList($data) {
        return $this->user->findOrFail(\Auth::user()->id)->shopsOwner()->with([
            'images',
            'court'
        ])->where(['sale_or_rental' => 'rental', 'status' => STATUS_PASS])->paginate(10)->toArray();
    }

    public function ysfFollowList($data) {
        return $this->user->findOrFail(\Auth::user()->id)->ysfsFollow()->with([
            'images',
            'court'
        ])->where(['status' => STATUS_PASS])->paginate($data->page)->toArray();
    }

    public function businessTransferFollowList($data) {
        return $this->user->findOrFail(\Auth::user()->id)->businessTransfersFollow()->with([
            'images',
            'court'
        ])->where(['status' => STATUS_PASS])->paginate($data->page)->toArray();
    }

    public function businessTransferOwnerList($data) {
        return $this->user->findOrFail(\Auth::user()->id)->businessTransfersOwner()->with([
            'images',
            'court'
        ])->paginate(10)->toArray();
    }

    public function workshopLandFollowList($data) {
        return $this->user->findOrFail(\Auth::user()->id)->workshopLandsFollow()->with([
            'images',
            'court'
        ])->where(['status' => STATUS_PASS])->paginate($data->page)->toArray();
    }

    public function workshopLandOwnerList($data) {
        return $this->user->findOrFail(\Auth::user()->id)->workshopLandsOwner()->with([
            'images',
            'court'
        ])->where('sale_or_rental','sale')->where('save_or_output','1')->where('status','1')->paginate(10)->toArray();
    }

    public function workshopRentOwnerList($data) {
        return $this->user->findOrFail(\Auth::user()->id)->workshopLandsOwner()->with([
            'images',
            'court'
        ])->where('sale_or_rental','rental')->where('save_or_output','1')->where('status','1')->paginate(10)->toArray();
    }



    public function appointmentList($data, $related, $sr) {
        $related .= 'Appointment';
        $r = $this->user->findOrFail(\Auth::user()->id)->$related()->with(['images', 'court']);
        $sr && $r = $r->where('sale_or_rental', $sr);

        return $r->paginate($data->page)->toArray();
    }

    public function beAppointed($category, $sr = null,$title) {
        $category .= 'sAgent';
        $result = $this->user->findOrFail(\Auth::user()->id)->$category();
        $sr && $result = $result->where('sale_or_rental', $sr)->where('title','like','%'.$title.'%');
        $result = $result->with([
            'images',
            'court',
            'user',
            'userBeAppointed' => function ($q) {
                $q->select('mobile', 'name')->withPivot('status')->withPivot('created_at');
            }
        ])->get();


        debug($result->toArray());

        return $result->toArray();
    }

    public function complete($category, $sr = null) {
        $category .= 'sAgent';
        $result = $this->user->findOrFail(\Auth::user()->id)->$category()->where(['status' => STATUS_COMPLETE]);
        $sr && $result = $result->where('sale_or_rental', $sr);
        $result = $result->with([
            'images',
            'court',
            'user',
            'userBeAppointed' => function ($q) {
                $q->select('mobile', 'name')->where('status', [2, 3])->withPivot('status');
            }
        ])->get();

        return $result->toArray();
    }

    public function complete2($category, $sr = null) {
        return $this->Pri_complete2(\Auth::user()->id, $category, $sr);
    }

    public function complete2ById($id, $category, $sr = null) {
        return $this->Pri_complete2($id, $category, $sr);
    }

    private function Pri_complete2($id, $category, $sr = null) {
        $category .= 'sAgent';
        $result = $this->user->findOrFail($id)->$category();
        $sr && $result = $result->where('sale_or_rental', $sr)->orderBy('created_at','desc');
        $result = $result->with([
            'images',
            'court',
            'user',
            'userBeAppointed' => function ($q) {
                $q->select('mobile', 'name')->withPivot('status');
            }
        ])->get();

        return $result->toArray();
    }

    public function manager($status, $category, $sr = null, $likeTitle = null) {
        return $this->Pri_manager(\Auth::user()->id, $status, $category, $sr, $likeTitle);
    }

    public function managerById($id, $status, $category, $sr = null, $likeTitle = null) {
        return $this->Pri_manager($id, $status, $category, $sr, $likeTitle);
    }

    private function Pri_manager($id, $status, $category, $sr = null, $likeTitle = null) {
        $category .= 'sAgent';
        $result = $this->user->findOrFail($id)->$category()->orderBy('created_at','desc')->where('status', $status);
        $sr && $result = $result->where('sale_or_rental', $sr);
        $likeTitle && $result = $result->where('title', 'like' ,'%'. $likeTitle . '%');
        $result = $result->with([
            'images',
            'court',
            'user',
            'userBeAppointed' => function ($q) {
                $q->select('mobile', 'name')->withPivot('status');
            }
        ])->get();

        return $result->toArray();
    }

    public function hadAppoint($category, $sr = null) {
        $category .= 'sAppointment';
        $result = $this->user->findOrFail(\Auth::user()->id)->$category();
        $sr && $result = $result->where('sale_or_rental', $sr);
        $result = $result->with([
            'images',
            'court',
            'agent',
//            'userBeAppointed' => function ($q) {
//                $q->select('mobile', 'name')->withPivot('status');
//            }
        ])->get();

        debug($result->toArray());

        return $result->toArray();
    }

    public function getAgentInfo($agentId) {
        return $this->user->select('id', 'name', 'mobile')->findOrFail($agentId);
    }

    public function getBrokerTags() {
        return $this->brokerTag->all();
    }

    public function storeComment($data) {
        $data->tags?
        $tags = implode(':', $data->tags) :
        $tags = '';
        
        return $this->user->findOrFail($data->agent_id)->agentsComments()->attach([
            \Auth::id() => [
                'source'     => $data->star,
                'tags'       => $tags
            ]
        ]);
    }

    public function updateStatus($data, $status) {
        $related = $data->related . 'sAppointment';
        $result = $this->user->findOrFail($data->id)->$related();
        $result->detach($data->related_id);
        $result->attach([$data->related_id => ['status' => $status]]);

    }

    public function getComments() {
        return $this->Pri_getComments(\Auth::id());
    }

    public function getCommentsById($id) {
        return $this->Pri_getComments($id);
    }

    private function Pri_getComments($id) {
        $result = $this->user->findOrFail($id)->agentsComments;
        return $result;
    }
}