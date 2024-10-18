<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTestimonialRequest;
use App\Models\Testimonial;
use App\Repositories\TestimonialRepository;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function __construct(private TestimonialRepository $testimonialRepository) {}

    public function home()
    {
        $testimonials = Testimonial::where('visible', true)->orderBy('order')->get();

        return view('landing-page')->with([
            'testimonials' => $testimonials,
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $testimonials = Testimonial::orderBy('order')->get();

        $testimonialsVisible = $testimonials->filter(function ($testimonial, $key) {
            return $testimonial->visible;
        })->values();

        $testimonialsNotVisible = $testimonials->filter(function ($testimonial, $key) {
            return ! $testimonial->visible;
        })->values();

        return view('index')->with([
            'testimonials' => $testimonials,
            'testimonialsVisible' => $testimonialsVisible,
            'testimonialsNotVisible' => $testimonialsNotVisible,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTestimonialRequest $request)
    {
        $this->testimonialRepository->storeTestimonial($request->validated());

        return redirect()->route('admin.testimonials.index')->with('success_message', 'Testimonial Created Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Testimonial $testimonial)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Testimonial $testimonial)
    {
        return view('edit')->with('testimonial', $testimonial);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Testimonial $testimonial)
    {
        $this->validate($request, [
            'name' => 'required',
            'quote' => 'required',
            'order' => 'required|numeric',
            'visible' => 'required|boolean',
        ]);

        $testimonial->fill($request->all())->save();

        return redirect()->route('admin.testimonials.index')
            ->with('success_message', 'Testimonial Updated Successfully!');
    }

    public function updateAll(Request $request)
    {
        $testimonials = Testimonial::all();

        foreach ($testimonials as $testimonial) {
            $testimonial->timestamps = false;
            $id = $testimonial->id;
            foreach ($request->testimonials as $testimonialFrontEnd) {
                if ($testimonialFrontEnd['id'] == $id) {
                    $testimonial->update(['order' => $testimonialFrontEnd['order']]);
                }
            }
        }

        return response('Update Successful.', 200);
    }

    public function updateVisibility(Request $request, Testimonial $testimonial)
    {
        $testimonial->visible = $request->visible;
        $testimonial->save();

        return response('Update Successful.', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();

        return back()->with('success_message', 'Testimonial Deleted Successfully.');
    }
}
