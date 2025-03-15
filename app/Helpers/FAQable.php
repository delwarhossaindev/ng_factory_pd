<?php 

namespace App\Helpers;

use App\Models\FAQ;

Trait FAQable
{   
    /**
     * Summary of hasFAQ
     * @return bool
     */
    public function hasFAQ()
    {
        return (bool) $this->faqs()->count();
    }
    
    /**
     * Summary of faqable
     * @return mixed
     */
    public function faqable()
    {
        return $this->morphTo();
    }
    
    /**
     * Summary of faq
     * @return mixed
     */
    public function faq()
    {
        return $this->morphOne(FAQ::class, 'faqable');
    }
    
    /**
     * Summary of faqs
     * @return mixed
     */
    public function faqs()
    {
        return $this->morphMany(FAQ::class, 'faqable');
    }
    
    /**
     * Summary of deleteFaq
     * @return mixed
     */
    public function deleteFaq()
    {
        return $this->faq()->delete();
    }
    
    /**
     * Summary of saveFaq
     * @param mixed $request
     * @return FAQable
     */
    public function saveFaq($request)
    {   
        foreach (array_filter($request->title) as $key => $value) {
            $this->faq()->create([
                'title' => $value,
                'description' => $request->faq_des[$key],
            ]);
        }

        return $this;
    }
}