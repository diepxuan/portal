---
trigger: always_on
glob:
description: GitHub PR workflow rules - use REST API instead of deprecated gh pr edit
---

# GitHub PR Workflow Rules

## gh pr edit không dùng được

Lệnh `gh pr edit` hiện **lỗi** vì dựa vào GraphQL `projectCards` đã bị GitHub deprecated:

```
GraphQL: Projects (classic) is being deprecated in favor of the new Projects experience
```

### Cách thay thế: dùng GitHub REST API

Để cập nhật PR body, title hoặc các field khác:

```bash
# Lấy repo name
REPO=$(gh repo view --json nameWithOwner -q .nameWithOwner)

# Lấy PR number từ current branch
PR_NUM=$(gh pr list --state open --head $(git branch --show-current) --json number -q .[0].number)

# Update body từ file
gh api repos/$REPO/pulls/$PR_NUM -X PATCH -F body=@/tmp/pr-body.md

# Update title
gh api repos/$REPO/pulls/$PR_NUM -X PATCH -F title="New Title"

# Update cả title và body
gh api repos/$REPO/pulls/$PR_NUM -X PATCH -F title="New Title" -F body=@/tmp/pr-body.md
```

### PR creation

- Dùng `gh pr create` để tạo PR mới (vẫn hoạt động bình thường).
- Ưu tiên GitHub app connector cho PR creation khi có thể.
