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

