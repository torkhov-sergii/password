<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Auth;
use View;
use Illuminate\Http\Request;
use Flash;
use Input;

class CommentsController extends Controller {

    public function index(Request $request)
    {
        $comments = Comment::latest('id')->paginate(10);

        return View::make('admin.comments.index', compact('comments'));
    }

    public function notApproved(Request $request)
    {
        $comments = Comment::where('approved', false)->paginate(10);

        return View::make('admin.comments.index', compact('comments'));
    }

    public function approve(Request $request, $id) {
        $comment = Comment::findOrFail($id);

        $comment->approve();

        return \Redirect::back();
    }

    public function destroy(Request $request, $id) {
        $comment = Comment::findOrFail($id);

        $comment->delete();

        return \Redirect::back();
    }

}
