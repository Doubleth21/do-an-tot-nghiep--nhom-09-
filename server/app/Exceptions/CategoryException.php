<?php

namespace App\Exceptions;

use Exception;

class CategoryException extends Exception
{
    public static function notFound(): self
    {
        return new self('Không tìm thấy danh mục', 404);
    }

    public static function cannotDelete(int $tourCount = 0): self
    {
        $message = 'Không thể xóa danh mục này';
        if ($tourCount > 0) {
            $message .= ' vì đang có ' . $tourCount . ' tour thuộc danh mục này';
        }
        
        return new self($message, 400);
    }

    public static function duplicateName(): self
    {
        return new self('Tên danh mục đã tồn tại', 400);
    }

    public static function invalidStatus(): self
    {
        return new self('Trạng thái danh mục không hợp lệ', 400);
    }
}