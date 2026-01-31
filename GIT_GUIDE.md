# 📚 HƯỚNG DẪN PUSH CODE LÊN GIT VÀ TẠO PULL REQUEST

## 1. TỔNG QUAN QUY TRÌNH

```
[Local Code] → [Git Add] → [Git Commit] → [Git Push] → [GitHub] → [Create PR] → [Merge]
```

---

## 2. PUSH CODE LÊN GIT (ĐÃ HOÀN THÀNH ✅)

### ✅ Các bước đã thực hiện:

1. **Tạo branch mới**
   ```bash
   git branch dat-tour
   ```

2. **Chuyển sang branch mới**
   ```bash
   git checkout dat-tour
   ```

3. **Add files cần push**
   ```bash
   git add server/app/Http/Controllers/Api/BookingController.php
   git add server/app/Models/Booking.php
   git add server/database/migrations/2026_01_31_075248_create_bookings_table.php
   git add server/routes/api.php
   git add API_POSTMAN_GUIDE.md
   ```

4. **Commit code**
   ```bash
   git commit -m "feat: Thêm chức năng đặt tour (booking) với API đầy đủ

   - Tạo model Booking với relationships
   - Tạo migration bookings table với các trường cần thiết
   - Tạo BookingController với các action CRUD đầy đủ
   - Thêm routes API cho booking management
   - Hỗ trợ phân quyền: user xem booking của mình, admin/tour_guide xem tất cả
   - Tính tự động tổng giá khi đặt tour
   - Thêm hướng dẫn chi tiết test API bằng Postman"
   ```

5. **Push lên GitHub**
   ```bash
   git push -u origin dat-tour
   ```

**✅ Kết quả:**
- Branch `dat-tour` đã được tạo
- Code đã được push lên GitHub
- Branch được tự động track origin/dat-tour

---

## 3. TẠO PULL REQUEST (MỘT LẦN)

### Cách 1: Qua GitHub Web (Recommended)

1. **Vào GitHub Repository**
   - Link: https://github.com/Doubleth21/do-an-tot-nghiep--nhom-09-

2. **Kiểm tra branch**
   - Sau khi push, GitHub sẽ tự động phát hiện branch mới
   - Nhấn vào tab "Pull requests"

3. **Click "New Pull Request" hoặc dùng shortcut**
   - GitHub sẽ gợi ý: "Compare & pull request"
   - Click nó!

4. **Fill PR Information:**
   ```
   Title: Thêm chức năng đặt tour (booking) API
   
   Description:
   ## 📋 Mô tả
   Thêm chức năng đặt tour cho khách hàng với hệ thống quản lý booking đầy đủ
   
   ## ✨ Thay đổi chính
   - [x] Tạo model Booking với relationships (belongsTo User, Tour)
   - [x] Migration bookings table với các field: user_id, tour_id, quantity, total_price, status, notes, booking_date, travel_date
   - [x] BookingController xử lý CRUD operations
   - [x] API routes cho booking management
   - [x] Phân quyền: user xem booking của mình, admin/tour_guide xem tất cả
   - [x] Tính tự động tổng giá = tour.price × quantity
   - [x] Hướng dẫn test API bằng Postman
   
   ## 🔗 Related Issues
   N/A
   
   ## 📝 Checklist
   - [x] Code đã được test
   - [x] Không có conflict
   - [x] Commit messages rõ ràng
   - [x] Documentation cập nhật
   ```

5. **Select Reviewers (Optional)**
   - Thêm thành viên nhóm để review

6. **Click "Create Pull Request"**

---

### Cách 2: Qua Command Line

```bash
# Nếu bạn có GitHub CLI installed
gh pr create --title "Thêm chức năng đặt tour (booking) API" \
             --body "## 📋 Mô tả\nThêm chức năng đặt tour..." \
             --base main \
             --head dat-tour
```

---

## 4. MỘI LẦN PUSH THÊM CODE (FUTURE)

Sau khi đã có branch `dat-tour`, nếu cần push thêm code:

### Option 1: Commit thêm và push
```bash
# 1. Sửa code
# vim server/app/Http/Controllers/Api/BookingController.php

# 2. Add changes
git add server/app/Http/Controllers/Api/BookingController.php

# 3. Commit
git commit -m "fix: Update BookingController logic"

# 4. Push
git push origin dat-tour
```

**💡 LƯU Ý:** Pull request sẽ tự động cập nhật các commit mới!

### Option 2: Amend commit (nếu chưa push)
```bash
# Sửa code
git add <files>

# Amend vào commit trước đó
git commit --amend --no-edit

# Push force (cẩn thận!)
git push -f origin dat-tour
```

---

## 5. MERGE PULL REQUEST

### Sau khi Approved:

1. **Vào GitHub PR page**
2. **Click "Merge pull request"**
3. **Chọn merge strategy:**
   - **Create a merge commit** (Recommended) - giữ lại toàn bộ history
   - **Squash and merge** - gộp tất cả commit lại 1 commit
   - **Rebase and merge** - rebase thay vì merge

4. **Click "Confirm merge"**

5. **Delete branch (Optional)**
   - GitHub sẽ gợi ý delete branch sau merge
   - Click "Delete branch"

6. **Sync local repo:**
   ```bash
   # Trở về main/master
   git checkout main
   
   # Pull changes từ remote
   git pull origin main
   
   # Delete local branch
   git branch -d dat-tour
   ```

---

## 6. WORKFLOW HOÀN CHỈNH (Step by Step)

### Development Phase
```bash
# 1. Create branch
git branch dat-tour
git checkout dat-tour

# 2. Make changes
# ... code code code ...

# 3. Check status
git status

# 4. Add files
git add .
# hoặc add từng file
git add server/app/Models/Booking.php
git add server/app/Http/Controllers/Api/BookingController.php

# 5. Commit
git commit -m "feat: Thêm booking feature"

# 6. View commit
git log --oneline -5
```

### Push to GitHub
```bash
# 1. Push lần đầu (set up tracking)
git push -u origin dat-tour

# 2. Push lần sau (chỉ cần git push)
git push origin dat-tour
```

### Create & Merge PR
```bash
# 1. Tạo PR qua GitHub Web

# 2. Wait for review

# 3. Merge PR (vào GitHub Web)

# 4. Sync local
git checkout main
git pull origin main
git branch -d dat-tour
```

---

## 7. USEFUL GIT COMMANDS

### Kiểm tra status
```bash
git status                    # View changes
git log --oneline -10         # View last 10 commits
git branch -a                 # View all branches
```

### Thay đổi branch
```bash
git checkout main             # Switch to main
git checkout dat-tour         # Switch to dat-tour
git checkout -b new-feature   # Create & switch new branch
```

### Undo changes
```bash
git restore <file>            # Discard changes (unstaged)
git reset HEAD <file>         # Unstage file
git revert <commit>           # Create new commit to undo
git reset --hard HEAD~1       # Delete last commit (dangerous!)
```

### Rebase & Sync
```bash
git fetch origin              # Fetch latest from remote
git rebase origin/main        # Rebase on main
git merge origin/main         # Merge main into current branch
```

### Stash (tạm lưu)
```bash
git stash                     # Save current changes
git stash list                # View stashed changes
git stash pop                 # Apply & delete stash
git stash apply               # Apply stash (keep it)
```

---

## 8. GIT COMMIT MESSAGE CONVENTION

### Format:
```
<type>(<scope>): <subject>

<body>

<footer>
```

### Types:
- **feat**: Thêm feature mới
- **fix**: Fix bug
- **docs**: Documentation changes
- **style**: Code style changes (formatting)
- **refactor**: Refactoring code
- **perf**: Performance improvements
- **test**: Adding tests
- **chore**: Build, dependencies, tools

### Examples:
```
feat(booking): Thêm chức năng đặt tour
fix(booking): Fix tính toán total_price
docs(booking): Thêm hướng dẫn Postman
refactor(booking): Optimize BookingController
```

---

## 9. COLLABORATION TIPS

### Trước khi push
```bash
# Update your branch
git fetch origin
git rebase origin/main

# Kiểm tra có conflict không
git status
```

### Xử lý conflict
```bash
# 1. Git sẽ báo conflicts
git status

# 2. Mở file conflict, sửa
# 3. Add lại
git add <resolved_files>

# 4. Continue rebase
git rebase --continue

# 5. Push
git push -f origin dat-tour
```

### Cleanup branches
```bash
# Xem branches cũ
git branch -v

# Delete local branch
git branch -d dat-tour

# Delete remote branch
git push origin --delete dat-tour
```

---

## 10. CURRENT STATUS

**Current Branch:** `dat-tour`
**Remote:** `origin/dat-tour` ✅

**Files Changed:**
- ✅ `server/app/Http/Controllers/Api/BookingController.php` (new)
- ✅ `server/app/Models/Booking.php` (new)
- ✅ `server/database/migrations/2026_01_31_075248_create_bookings_table.php` (new)
- ✅ `server/routes/api.php` (modified)
- ✅ `API_POSTMAN_GUIDE.md` (new)

**Next Steps:**
1. ✅ Code pushed to `dat-tour`
2. ⏳ Create Pull Request
3. ⏳ Wait for review
4. ⏳ Merge to main

---

## 11. TROUBLESHOOTING

### Error: "Permission denied (publickey)"
```bash
# Generate SSH key
ssh-keygen -t ed25519 -C "your_email@example.com"

# Add to GitHub settings
# Settings → SSH and GPG keys → New SSH key
```

### Error: "Merge conflict"
```bash
# 1. Fix conflicts in files
# 2. git add .
# 3. git commit -m "Resolve merge conflicts"
# 4. git push origin dat-tour
```

### Error: "Repository not found"
```bash
# Check remote URL
git remote -v

# Update if needed
git remote set-url origin https://github.com/Doubleth21/do-an-tot-nghiep--nhom-09-.git
```

### Push bị reject
```bash
# Fetch và pull trước
git fetch origin
git pull origin dat-tour

# Sau đó push lại
git push origin dat-tour
```

---

## 12. REFERENCES

- [GitHub Docs - Creating Pull Request](https://docs.github.com/en/pull-requests/collaborating-with-pull-requests/proposing-changes-to-your-work-with-pull-requests/creating-a-pull-request)
- [Git Official Docs](https://git-scm.com/doc)
- [Conventional Commits](https://www.conventionalcommits.org/)

---

**Chúc bạn làm việc hiệu quả với Git! 🚀**
