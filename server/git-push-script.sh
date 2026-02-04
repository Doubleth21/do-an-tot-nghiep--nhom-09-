#!/bin/bash

# 🚀 SCRIPT ĐẨY TOUR MANAGEMENT LÊN GIT
# Copy và chạy từng lệnh trong terminal

echo "🚀 Starting Git push process for Tour Management System..."

# Bước 1: Kiểm tra Git status
echo "📋 Step 1: Checking Git status..."
git status

# Bước 2: Tạo .gitignore nếu chưa có
echo "📝 Step 2: Creating .gitignore..."
cat > .gitignore << 'EOF'
# Laravel
/vendor
/node_modules
/public/hot
/public/storage
/storage/*.key
.env
.env.backup
.phpunit.result.cache
docker-compose.override.yml
Homestead.json
Homestead.yaml
npm-debug.log
yarn-error.log

# IDE
.vscode/
.idea/
*.swp
*.swo

# OS
.DS_Store
Thumbs.db

# Logs
storage/logs/*.log
bootstrap/cache/*.php
EOF

# Bước 3: Add tất cả files
echo "➕ Step 3: Adding all files..."
git add .

# Bước 4: Commit với message chi tiết
echo "💾 Step 4: Committing changes..."
git commit -m "feat: complete tour management system

🎉 Features Implemented:
✅ Database Models & Migrations
- Tour model with relationships and scopes
- Category model with tour relationship
- Comprehensive migrations with proper indexing
- Sample data seeders and factories

✅ REST API Backend
- TourController with full CRUD operations
- CategoryController with CRUD operations
- DashboardController for statistics
- TestController for development testing
- API Resources for consistent responses

✅ Authentication & Security
- Laravel Sanctum token-based authentication
- Role-based access control (admin, tour_guide, user)
- CheckRole middleware for route protection
- Comprehensive form validation

✅ Web Interface
- Responsive Bootstrap 5 design
- Tour listing with search and filters
- CRUD forms (Create, Edit, Delete)
- Tour detail view with comprehensive info
- Category management interface

✅ Advanced Features
- File upload support for tour images
- Search, filter, and pagination
- Service layer for business logic
- Custom exceptions and error handling
- API response traits and helpers

✅ Testing & Documentation
- Feature tests for API endpoints
- Model factories for test data
- Comprehensive API documentation
- Setu