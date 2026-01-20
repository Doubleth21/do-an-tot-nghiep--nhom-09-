import { useState } from "react";

export const useImageUpload = () => {
    const [images, setImages] = useState([]);
    const [previews, setPreviews] = useState([]); // Thêm setPreviews vào trả về

    const handleImagesChange = (e) => {
        const files = Array.from(e.target.files);
        setImages(prev => [...prev, ...files]);

        const newPreviews = files.map(file => URL.createObjectURL(file));
        setPreviews(prev => [...prev, ...newPreviews]);
    };

    const removeImage = (index) => {
        // Chỉ revoke nếu đó là blob mới tạo, nếu là link ảnh web thì không cần
        if (previews[index].startsWith('blob:')) {
            URL.revokeObjectURL(previews[index]);
        }
        setImages(prev => prev.filter((_, i) => i !== index));
        setPreviews(prev => prev.filter((_, i) => i !== index));
    };

    // Thêm setPreviews vào mảng return
    return { images, previews, setPreviews, handleImagesChange, removeImage };
};