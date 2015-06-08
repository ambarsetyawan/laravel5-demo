<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\CreateTagRequest;
use Illuminate\Http\Request;
use App\Libraries\Repositories\TagRepository;
use Mitul\Controller\AppBaseController;
use Response;
use Flash;

class TagController extends AppBaseController
{

	/** @var  TagRepository */
	private $tagRepository;

	function __construct(TagRepository $tagRepo)
	{
		$this->tagRepository = $tagRepo;
	}

	/**
	 * Display a listing of the Tag.
	 *
	 * @param Request $request
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
	    $input = $request->all();

		$result = $this->tagRepository->search($input);

		$tags = $result[0];

		$attributes = $result[1];

		return view('tags.index')
		    ->with('tags', $tags)
		    ->with('attributes', $attributes);;
	}

	/**
	 * Show the form for creating a new Tag.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('tags.create');
	}

	/**
	 * Store a newly created Tag in storage.
	 *
	 * @param CreateTagRequest $request
	 *
	 * @return Response
	 */
	public function store(CreateTagRequest $request)
	{
        $input = $request->all();

		$tag = $this->tagRepository->store($input);

		Flash::message('Tag saved successfully.');

		return redirect(route('tags.index'));
	}

	/**
	 * Display the specified Tag.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function show($id)
	{
		$tag = $this->tagRepository->findTagById($id);

		if(empty($tag))
		{
			Flash::error('Tag not found');
			return redirect(route('tags.index'));
		}

		return view('tags.show')->with('tag', $tag);
	}

	/**
	 * Show the form for editing the specified Tag.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$tag = $this->tagRepository->findTagById($id);

		if(empty($tag))
		{
			Flash::error('Tag not found');
			return redirect(route('tags.index'));
		}

		return view('tags.edit')->with('tag', $tag);
	}

	/**
	 * Update the specified Tag in storage.
	 *
	 * @param  int    $id
	 * @param CreateTagRequest $request
	 *
	 * @return Response
	 */
	public function update($id, CreateTagRequest $request)
	{
		$tag = $this->tagRepository->findTagById($id);

		if(empty($tag))
		{
			Flash::error('Tag not found');
			return redirect(route('tags.index'));
		}

		$tag = $this->tagRepository->update($tag, $request->all());

		Flash::message('Tag updated successfully.');

		return redirect(route('tags.index'));
	}

	/**
	 * Remove the specified Tag from storage.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function destroy($id)
	{
		$tag = $this->tagRepository->findTagById($id);

		if(empty($tag))
		{
			Flash::error('Tag not found');
			return redirect(route('tags.index'));
		}

		$tag->delete();

		Flash::message('Tag deleted successfully.');

		return redirect(route('tags.index'));
	}

}
