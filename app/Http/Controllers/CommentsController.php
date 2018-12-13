<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Main;
use App\Models\User;
use Auth;
use View;
use App\Models\Comment;
use Illuminate\Http\Request;
use Flash;
use Input;
use Mail;

class CommentsController extends Controller {

    //Stores a new comments.
    public function store(Request $request)
    {
        $user= Auth::user();

		$subject_id = $request->get('subject_id');
		$subject_model = $request->get('subject_model'); //Main, User...
		$title = $request->get('title');
		$message = $request->get('message');
        $name = $request->get('name');
        $email = $request->get('email');
        $website = $request->get('website');

        if($message != '') {
            $model = 'App\Models\\'.$subject_model;
            $obj = new $model();
            $subject_item = $obj::findOrfail($subject_id);

//        if($user) {
//            $comment = $user->comment($subject_item, $message, 1);
//        }
//        else {
            $comment = new Comment([
                'body'        => $message,
                'name'        => $name,
                'email'        => $email,
                'website'        => $website,
                'rate'           => ($subject_item->getCanBeRated()) ? 1 : null,
                'approved'       => false,
                'commented_id'   => '',
                'commented_type' => ''
            ]);

            $subject_item->comments()->save($comment);

            session()->push('user_comments_ids', $comment->id);
//        }

            //родительское сообщение - обязательно для создния ЦЕПОЧКИ
            $parent = null;
            $parent_id = $request->get('parent_id');
            if($parent_id) {
                $parent = Comment::findorFail($parent_id);
                $comment->makeChildOf($parent);
            }

            Flash::success(trans('main.comments.comment_has_been_added'));
        }

		return \Redirect::back();
    }
}
