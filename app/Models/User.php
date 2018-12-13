<?php namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Mail;
use Input;
use Auth;
use App\Models\Traits\ImagesTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Eloquent;
use Jrean\UserVerification\Traits\UserVerification;
use Jrean\UserVerification\Traits\VerifiesUsers;
use Laratrust\Traits\LaratrustUserTrait;
use App\Models\Traits\CanComment;
use App\Notifications\CustomResetPassword;


class User extends Authenticatable {

	use ImagesTrait, Notifiable, VerifiesUsers, UserVerification, CanComment, LaratrustUserTrait;

	protected $table = 'users';
	protected $fillable = ['login', 'email', 'password', 'name', 'surname', 'secondname', 'dateofbirth', 'phone'];
	protected $hidden = ['password', 'remember_token'];

    protected $appends = [
        'full_name',
    ];

    public function sendPasswordResetNotification($token)
    {
        //dd($token);
        $this->notify(new CustomResetPassword($token));
    }

    //получить юзера
	public function getUser($userId) {
		$user = User::find($userId);
		return $user;
	}

	//сохранить инфу о юзере
    public function postUser() {
		$data = Input::except('_token');

		//формируем дату обратно в формат Y-m-d
		$dateofbirth = Carbon::createFromDate($data['dateofbirth_y'], $data['dateofbirth_m'], $data['dateofbirth_d'])->format('Y-m-d');
		$this->setAttribute('dateofbirth', $dateofbirth);

		$this->update($data);
	}

	//ковертим дату рождения в Carbon объект
	public  function getCarbonDate() {
		$this->setAttribute('dateofbirth', Carbon::parse($this->dateofbirth));
		return $this->dateofbirth;
	}

	//получить возраст пользователя
	public  function getAge() {
		$dateofbirth = Carbon::parse($this->dateofbirth);
		$age = $dateofbirth->age;
		if($age < 0 || $age > 100) $age = null;
		return $age;
	}

	//получить баланс пользователя
	public function getBalance() {
		if(!isset($this->getBalance)) {
			$last_record = AccountBalance::where('user_id', '=', $this->id)->orderBy('id', 'DESC')->first();

			if($last_record) $balance = $last_record->balance;
			else $balance = 0;
			$this->getBalance = $balance;
		}

		return $this->getBalance;
	}

	//получить замороженный баланс пользователя.
	public function getBalanceFrozen() {
		if(!isset($this->getBalanceFrozen)) {
			$frozen = AccountBalance::where('user_id', '=', $this->id)->where('status', '=', 'frozen')->sum('amount');

			if($frozen) $balance_frozen = abs($frozen);
			else $balance_frozen = 0;
			$this->getBalanceFrozen = $balance_frozen;
		}

		return $this->getBalanceFrozen;
	}

	//добавляем юзера (добавили в админке)
	public function register() {
		$this->password = \Hash::make($this->password);
		//$this->activationCode = $this->generateCode(); //код активации для подтверждения мыла
		$this->verified = true;
		$this->save();

		return $this->id;
	}

	//генерируем код активации подтверждения мыла
	protected function generateCode() {
		return Str::random(); // По умолчанию длина случайной строки 16 символов
	}

    public function getAllowCategories() {
        $arr = explode(',', $this->roles->first()->allow_categories);

        if($arr[0] == '') return [];
        else return $arr;
    }

//	//активация юзера (перешел по ссылке из письма)
//	public function activate($activationCode) {
//		// Если пользователь уже активирован, не будем делать никаких
//		// проверок и вернем false
//		if ($this->isActive) {
//			return false;
//		}
//
//		// Если коды не совпадают, то также ввернем false
//		if ($activationCode != $this->activationCode) {
//			return false;
//		}
//
//		// Обнулим код, изменим флаг isActive и сохраним
//		$this->activationCode = '';
//		$this->isActive = true;
//		$this->save();
//
//		return true;
//	}

	//получить нотификации юзера
	public function getNotifications() {
		$comments = $this->comments()->where('status', '=', 'notification')->where('isRead', '!=', 1);

		return $comments->get();
	}

	//получить роль юзера
	public function getRole($param) {
		if(isset($this->roles[0])) return $this->roles[0]->$param;
//		else {
//			if($param == 'name') return 'user';
//		}
	}

    //возвращяет профайл юзера - соц. сеть
    public function getProfileProvider($provider) {
        return $this->profile->where('provider', $provider)->first();
    }

    public function getFullNameAttribute()
    {
        if($this->name || $this->surname) return $this->name . ' ' . $this->surname;
        else return $this->secondname;
    }

    //получить имя и фамилию
    public function fullname() {
        return $this->name.' '.$this->surname;
    }

    //region RELATION
    public function comments() {
        return $this->morphMany('App\Models\Comment', 'commentable');
    }
    //endregion
}
