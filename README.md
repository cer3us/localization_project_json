# Localization Project (JSON)

A Laravel 12 application for managing multilingual content – projects, documents, and automated translations. API only, no WebApp.

## ✨ Features
- **User accounts** with Sanctum API authentication
- **Projects** – each with a source language and multiple target languages
- **Documents** – store source text segments as JSON
- **Translations** – automatically generated using Google Translate (free tier)
- **Progress tracking** – translation progress per document
- **RESTful API** – fully documented with Swagger/OpenAPI
- **Dockerized** – easy setup with Laravel Sail

## 🛠️ Requirements
- Docker & Docker Compose
- PHP 8.2+ (inside container)
- Composer (for initial setup)

## 🚀 Access the application
API base: http://localhost/api/v1
Swagger docs: http://localhost/api-docs

🔹 Endpoints / Маршруты
| Method/Метод | Endpoint/URL | Description/Описание | HTTP Status Codes / Коды состояния HTTP |
| --- | --- | --- | --- |
| POST | /api/v1/account/create | Create a new Account with the provided data | 201 Created |
| POST | /api/v1/account/sign-in | Sign-in into the account (token returned) | 200 Ok |
| GET | /api/v1/account | Get the signed-in account info | 200 Ok |
| GET | /api/v1/languages | Get the list of all languages used in the projects | 200 Ok |
| POST | /api/v1/projects | Add a new project | 201 Created |
| GET | /api/v1/projects/{project} | Get a specific project | 200 OK |
| PATCH | /api/v1/projects/{project} | Update a project  | 200 OK |
| DELETE | /api/v1/projects/{project} | Delete a project  | 204 OK |
| POST | /api/v1/documents | Add documents to a project  | 201 Created |
| GET | /api/v1/documents | Get a list of documents for a specific project  | 200 OK |
| DELETE | /api/v1/documents/{document} | Delete a document  | 204 |
| GET | /api/v1/documents/{document} | Get a document  | 200 OK |
| POST | /api/v1/documents/{document}/import | Add translations to a specific document  | 201 Created |
| GET | /api/v1/users | Get a list of users  | 200 OK |
| GET | /api/v1/team/projects | Get a list of projects for the authenticated user  | 200 OK |
| POST | /api/v1/team/assign-performer | Assign a performer for a specific project | 201 CREATED |

## 📚 API Documentation
- Interactive API documentation is automatically generated and available at /api-docs. It lists all endpoints, expected parameters, and some example responses.
- To explore the API, you can use tools like Postman or simply visit the URL above.
- LocJSON.postman_collection.json is inclueded in the root directory.

## 🧪 Testing
- Some simple example feature tests included.

## 🌐 Translation Helper
- `tanmuhittin/laravel-google-translate` is used to work with Google/Yandex Translate APIs.
- The translate() helper (available globally) uses the `stichoza/google-translate-php` package to translate text between languages without using APIs (for free). It expects ISO 639-1 language codes (e.g., en, fr, ja).

## 📄 License
MIT – do whatever you want, but attribution is appreciated. Thank you!

