<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\CreateCategoryRequest;
use Illuminate\Http\Request;
use App\Libraries\Repositories\CategoryRepository;
use Mitul\Controller\AppBaseController;
use Response;
use Flash;

class CategoryController extends AppBaseController
{

	/** @var  CategoryRepository */
	private $categoryRepository;

	function __construct(CategoryRepository $categoryRepo)
	{
		$this->categoryRepository = $categoryRepo;
	}

	/**
	 * Display a listing of the Category.
	 *
	 * @param Request $request
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
	    $input = $request->all();

		$result = $this->categoryRepository->search($input);

		$categories = $result[0];

		$attributes = $result[1];

		return view('categories.index')
		    ->with('categories', $categories)
		    ->with('attributes', $attributes);;
	}

	/**
	 * Show the form for creating a new Category.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('categories.create');
	}

	/**
	 * Store a newly created Category in storage.
	 *
	 * @param CreateCategoryRequest $request
	 *
	 * @return Response
	 */
	public function store(CreateCategoryRequest $request)
	{
        $input = $request->all();

		$category = $this->categoryRepository->store($input);

		Flash::message('Category saved successfully.');

		return redirect(route('categories.index'));
	}

	/**
	 * Display the specified Category.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function show($id)
	{
		$category = $this->categoryRepository->findCategoryById($id);

		if(empty($category))
		{
			Flash::error('Category not found');
			return redirect(route('categories.index'));
		}

		return view('categories.show')->with('category', $category);
	}

	/**
	 * Show the form for editing the specified Category.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$category = $this->categoryRepository->findCategoryById($id);

		if(empty($category))
		{
			Flash::error('Category not found');
			return redirect(route('categories.index'));
		}

		return view('categories.edit')->with('category', $category);
	}

	/**
	 * Update the specified Category in storage.
	 *
	 * @param  int    $id
	 * @param CreateCategoryRequest $request
	 *
	 * @return Response
	 */
	public function update($id, CreateCategoryRequest $request)
	{
		$category = $this->categoryRepository->findCategoryById($id);

		if(empty($category))
		{
			Flash::error('Category not found');
			return redirect(route('categories.index'));
		}

		$category = $this->categoryRepository->update($category, $request->all());

		Flash::message('Category updated successfully.');

		return redirect(route('categories.index'));
	}

	/**
	 * Remove the specified Category from storage.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function destroy($id)
	{
		$category = $this->categoryRepository->findCategoryById($id);

		if(empty($category))
		{
			Flash::error('Category not found');
			return redirect(route('categories.index'));
		}

		$category->delete();

		Flash::message('Category deleted successfully.');

		return redirect(route('categories.index'));
	}

}
