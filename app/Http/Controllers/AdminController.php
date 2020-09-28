<?php

namespace App\Http\Controllers;

use App\Blog;
use App\Blogcategory;
use App\Blogtag;
use App\Category;
use App\Role;
use App\Tag;
use App\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function addTag(Request $request) {
        // validate
        $this->validate($request, [
            'tagName' => 'required'
        ]);
        return Tag::create([
            'tagName'=> $request->tagName
        ]);
    }

    public function editTag(Request $request) {
        // validate
        $this->validate($request, [
            'id' => 'required',
            'tagName' => 'required'
        ]);
        return Tag::where('id', $request->id)->update([
            'tagName'=> $request->tagName
        ]);
    }

    public function deleteTag(Request $request) {
        // validate
        $this->validate($request, [
            'id' => 'required',
        ]);
        return Tag::where('id', $request->id)->delete();
    }

    public function getTag() {
        return Tag::orderBy('id', 'desc')->get();
    }

    public function upload(Request $request)
    {
        $this->validate($request,[
            'file' => 'required|mimes:jpeg,jpg,png'
        ]);
        $picName = time().'.'.$request->file->extension();
        $request->file->move(public_path('uploads'), $picName);
        return $picName;
    }

    public function deleteImage(Request $request) {
        $fileName = $request->imageName;
        $this->deleteFileFromServer($fileName, false);
        return 'done';
    }

    public function deleteFileFromServer($fileName) {
        $filePath = public_path().'/uploads/'.$fileName;
        if(file_exists($filePath)){
            @unlink($filePath);
        }
        return;
    }

    public function addCategory(Request $request) {
        // validate 
        $this->validate($request, [
            'categoryName' => 'required',
            'iconImage' => 'required'
        ]);
        return Category::create([
            'categoryName'=> $request->categoryName,
            'iconImage' => $request->iconImage
        ]);
    }

    public function editCategory(Request $request) {
        // validate
        $this->validate($request, [
            'id' => 'required',
            'categoryName' => 'required',
            'iconImage' => 'required'
        ]);
        return Category::where('id', $request->id)->update([
            'categoryName'=> $request->categoryName,
            'iconImage'=> $request->iconImage
        ]);
    }

    public function deleteCategory(Request $request) {
        // validate
        $this->validate($request, [
            'id' => 'required',
        ]);
        return Category::where('id', $request->id)->delete();
    }

    public function getCategory() {
        return Category::orderBy('id', 'desc')->get();
    }
}