# E-Course UNSIA API Documentation

## Base URL
```
http://localhost:8000/api/v1
```

## Authentication
This API uses Laravel Sanctum for authentication. Include the Bearer token in the Authorization header:

```
Authorization: Bearer your_api_token_here
```

## Response Format
All API responses follow this format:

```json
{
    "success": true|false,
    "message": "Response message",
    "data": {
        // Response data
    },
    "errors": {
        // Validation errors (only on error)
    }
}
```

## Endpoints

### Authentication

#### Register User
- **POST** `/register`
- **Body:**
```json
{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123"
}
```
- **Response:** User data with API token

#### Login
- **POST** `/login`
- **Body:**
```json
{
    "email": "john@example.com",
    "password": "password123"
}
```
- **Response:** User data with API token

#### Logout
- **POST** `/logout`
- **Headers:** `Authorization: Bearer {token}`
- **Response:** Success message

#### Get Current User
- **GET** `/user`
- **Headers:** `Authorization: Bearer {token}`
- **Response:** Current user data

#### Update Profile
- **PUT** `/user`
- **Headers:** `Authorization: Bearer {token}`
- **Body:**
```json
{
    "name": "John Doe Updated",
    "email": "john.updated@example.com",
    "password": "newpassword123",
    "password_confirmation": "newpassword123"
}
```

### Courses

#### Get All Courses
- **GET** `/courses`
- **Query Parameters:** 
  - `search` - Search in title, description, category
  - `kategori` - Filter by category
  - `per_page` - Items per page (default: 15)
- **Example:** `/courses?search=programming&kategori=Pemrograman&per_page=10`

#### Get Single Course
- **GET** `/courses/{id}`
- **Response:** Course with materials and user data

#### Create Course
- **POST** `/courses`
- **Headers:** `Authorization: Bearer {token}`
- **Body:** `multipart/form-data`
```
judul: Course Title
deskripsi: Course description
kategori: Pemrograman
thumbnail: [image file]
```

#### Update Course
- **PUT** `/courses/{id}`
- **Headers:** `Authorization: Bearer {token}`
- **Body:** `multipart/form-data`
```
judul: Updated Course Title
deskripsi: Updated description
kategori: Design
thumbnail: [image file] (optional)
```

#### Delete Course
- **DELETE** `/courses/{id}`
- **Headers:** `Authorization: Bearer {token}`

### Materials

#### Get All Materials
- **GET** `/materials`
- **Query Parameters:**
  - `course_id` - Filter by course
  - `tipe` - Filter by type (article, video, pdf, audio, image)
  - `search` - Search in title, description
  - `per_page` - Items per page (default: 15)

#### Get Single Material
- **GET** `/materials/{id}`
- **Response:** Material with course, user, and comments

#### Create Material
- **POST** `/materials`
- **Headers:** `Authorization: Bearer {token}`
- **Body:** `multipart/form-data`

For file-based materials (video, pdf, audio, image):
```
course_id: 1
judul: Material Title
deskripsi: Material description
tipe: video
file: [video file]
```

For article materials:
```
course_id: 1
judul: Article Title
deskripsi: Article description
tipe: article
content: <h1>Article HTML content</h1><p>Article body...</p>
```

#### Update Material
- **PUT** `/materials/{id}`
- **Headers:** `Authorization: Bearer {token}`
- **Body:** Same as create, all fields optional except required ones

#### Delete Material
- **DELETE** `/materials/{id}`
- **Headers:** `Authorization: Bearer {token}`

### Comments

#### Get Material Comments
- **GET** `/materials/{material_id}/comments`
- **Response:** Paginated hierarchical comments

#### Add Comment
- **POST** `/materials/{material_id}/comments`
- **Headers:** `Authorization: Bearer {token}`
- **Body:**
```json
{
    "body": "This is a comment",
    "parent_id": null // or comment ID for replies
}
```

#### Update Comment
- **PUT** `/comments/{id}`
- **Headers:** `Authorization: Bearer {token}`
- **Body:**
```json
{
    "body": "Updated comment text"
}
```

#### Delete Comment
- **DELETE** `/comments/{id}`
- **Headers:** `Authorization: Bearer {token}`

### Admin Endpoints
*Requires admin role*

#### Get Pending Materials
- **GET** `/admin/approvals`
- **Headers:** `Authorization: Bearer {admin_token}`
- **Query Parameters:**
  - `tipe` - Filter by material type
  - `course_id` - Filter by course
  - `per_page` - Items per page

#### Review Material
- **GET** `/admin/approvals/{material_id}`
- **Headers:** `Authorization: Bearer {admin_token}`

#### Approve/Reject Material
- **PUT** `/admin/approvals/{material_id}`
- **Headers:** `Authorization: Bearer {admin_token}`
- **Body:**
```json
{
    "status": "approved" // or "rejected"
}
```

#### Get Admin Statistics
- **GET** `/admin/stats`
- **Headers:** `Authorization: Bearer {admin_token}`
- **Response:** Dashboard statistics

## Error Codes

- **200** - Success
- **201** - Created
- **401** - Unauthorized
- **403** - Forbidden
- **404** - Not Found
- **422** - Validation Error
- **500** - Server Error

## Example Usage with cURL

### Register and Login
```bash
# Register
curl -X POST http://localhost:8000/api/v1/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "John Doe", 
    "email": "john@example.com", 
    "password": "password123",
    "password_confirmation": "password123"
  }'

# Login
curl -X POST http://localhost:8000/api/v1/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "john@example.com", 
    "password": "password123"
  }'
```

### Get Courses
```bash
curl -X GET http://localhost:8000/api/v1/courses
```

### Create Course (with authentication)
```bash
curl -X POST http://localhost:8000/api/v1/courses \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -F "judul=Laravel Programming" \
  -F "deskripsi=Learn Laravel from scratch" \
  -F "kategori=Pemrograman" \
  -F "thumbnail=@/path/to/image.jpg"
```

### Upload Material
```bash
curl -X POST http://localhost:8000/api/v1/materials \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -F "course_id=1" \
  -F "judul=Introduction Video" \
  -F "deskripsi=Course introduction" \
  -F "tipe=video" \
  -F "file=@/path/to/video.mp4"
```

## Notes

- All file uploads have a maximum size of 10MB for materials and 2MB for thumbnails
- API tokens expire after 7 days by default
- Only approved courses and materials are visible to regular users
- Admin users can see and manage all content regardless of status
- Comments support hierarchical structure (replies to replies)
- Pagination is available on list endpoints with metadata in response 