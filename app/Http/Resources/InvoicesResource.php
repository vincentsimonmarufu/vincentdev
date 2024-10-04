<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InvoicesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'surname' => $this->surname,
            'email' => $this->email,
            'description' => $this->description,
            'amount' => $this->amount,
            'invoice_id' => $this->invoice_id,
            'file' => $this->file_path,
            'fileUrl' =>  $this->file_path ? asset('storage/invoices/' . $this->file_path) : 'file not found',
            'status' => $this->status,
            'created_date' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_date' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
