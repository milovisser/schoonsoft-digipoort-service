<?php

namespace App;

enum XbrlMessageStatus: string
{
    case Pending = 'pending';
    case Processing = 'processing';
    case Sent = 'sent';
    case Delivered = 'delivered';
    case Failed = 'failed';
    case Rejected = 'rejected';
}
