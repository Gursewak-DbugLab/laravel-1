<?php

namespace App\Repositories;

use App\Models\Testimonial;

class TestimonialRepository
{
    public function getTestimonialById(int $id, array $relations = []): Testimonial
    {
        return Testimonial::findOrFail($id);
    }

    public function storeTestimonial(array $request): Testimonial
    {
        $testimonial = Testimonial::create($request);

        return $testimonial;
    }
}
