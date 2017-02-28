<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Channel;

class ChannelTransformer extends TransformerAbstract
{

    public function transform(Channel $channel)
    {
        return [
            'name' => $channel->name,
            'slug' => $channel->slug,
            'image' => $channel->getImage()
        ];
    }

}