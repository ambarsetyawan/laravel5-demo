<?php namespace App\Http\Controllers\API;

use App\Http\Requests;
use Mitul\Controller\AppBaseController;
use Mitul\Generator\Utils\ResponseManager;
use App\Category;
use Illuminate\Http\Request;
use App\Libraries\Repositories\CategoryRepository;
use Response;
use Schema;

class CategoryAPIController extends AppBaseController
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

		return Response::json(ResponseManager::makeResult($categories->toArray(), "Categories retrieved successfully."));
	}

	public function search($input)
    {
        $query = Category::query();

        $columns = Schema::getColumnListing('$TABLE_NAME$');
        $attributes = array();

        foreach($columns as $attribute)
        {
            if(isset($input[$attribute]))
            {
                $query->where($attribute, $input[$attribute]);
            }
        }

        return $query->get();
    }

	/**
	 * Show the form for creating a new Category.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created Category in storage.
	 *
	 * @param Request $request
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		if(sizeof(Category::$rules) > 0)
            $this->validateRequest($request, Category::$rules);

        $input = $request->all();

		$category = $this->categoryRepository->store($input);

		return Response::json(ResponseManager::makeResult($category->toArray(), "Category saved successfully."));
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
			$this->throwRecordNotFoundException("Category not found", ERROR_CODE_RECORD_NOT_FOUND);

		return Response::json(ResponseManager::makeResult($category->toArray(), "Category retrieved successfully."));
	}

	/**
	 * Show the form for editing the specified Category.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified Category in storage.
	 *
	 * @param  int    $id
	 * @param Request $request
	 *
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$category = $this->categoryRepository->findCategoryById($id);

		if(empty($category))
			$this->throwRecordNotFoundException("Category not found", ERROR_CODE_RECORD_NOT_FOUND);

		$input = $request->all();

		$category = $this->categoryRepository->update($category, $input);

		return Response::json(ResponseManager::makeResult($category->toArray(), "Category updated successfully."));
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
			$this->throwRecordNotFoundException("Category not found", ERROR_CODE_RECORD_NOT_FOUND);

		$category->delete();

		return Response::json(ResponseManager::makeResult($id, "Category deleted successfully."));
	}
}
