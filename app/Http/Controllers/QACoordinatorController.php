<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Idea;
use Illuminate\Http\Request;

class QACoordinatorController extends Controller
{
    public function home() {
        return view("qa_coordinator.home");
    }

    public function categoryManagement(){
        $categories = Category::all();
        return view('qa_coordinator.categoryManagement', compact('categories'));
    }

    public function newCategory(){
        return view('qa_coordinator.newCategory');
    }

    public function createNewCategory(Request $request){
        // Check input data
        $request->validate([
            'name' => ['required', 'unique:categories,name']
        ]);
        // Save to Database
        Category::create([
            'name'    => $request->name
        ]);

        return redirect()->back()->with('success', 'New category added successfully!');
    }

    public function deleteCategory($categoryId){
        $category = Category::findOrFail($categoryId);

        if (Idea::where('categoryId', $categoryId)->exists()){
            return back()->with('error', 'Cannot delete category that has ideas.');
        }
        $category->delete();
        return back()->with('success', 'Category deleted successfully.');
    }

    public function viewUpdateCategory($categoryId){
        $category = Category::findOrFail($categoryId);
        return view('qa_coordinator.updateCategory', compact('category'));
    }

    public function updateCategory(Request $request, $categoryId){
        $request->validate([
            'name' => ['required'],
        ]);
        $category = Category::findOrFail($categoryId);
        $category->name = $request->name;

        $category->save();

        return redirect('/categoryManagement');
    }

    public function ideaManagement(){
        $ideas = Idea::all();
        return view('qa_coordinator.ideaManagement', compact('ideas'));
    }

    public function deleteIdea($ideaId){
        $idea = Idea::findOrFail($ideaId);
        $idea->delete();
        return back()->with('success', 'Idea deleted successfully.');
    }

}
