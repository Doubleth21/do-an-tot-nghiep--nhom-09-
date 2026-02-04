<?php

namespace App\Exceptions;

use Exception;

class TourException extends Exception
{
    public static function notFound(): self
    {
        return new self('Không tìm thấy tour', 404);
    }

    public static function cannotDelete(string $reason = ''): self
    {
        $message = 'Không thể xóa tour';
        if ($reason) {
            $message .= ': ' . $reason;
        }
        
        return new self($message, 400);
    }

    public static function invalidStatus(): self
    {
        return new self('Trạng thái tour không hợp lệ', 400);
    }

    public static function dateConflict(): self
    {
        return new self('Ngày kết thúc phải sau ngày bắt đầu', 400);
    }

    public static function pastDate(): self
    {
        return new self('Ngày bắt đầu phải sau ngày hiện tại', 400);
    }

    public static function imageUploadFailed(): self
    {
        return new self('Không thể upload hình ảnh', 500);
    }
}