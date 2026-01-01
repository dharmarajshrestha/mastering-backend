# 🗓️ Day 1 — Naive Implementation (Feel the Pain)

## 🎯 Goal

Experience why **Object-Oriented Programming (OOP)** and clean architecture matter by intentionally doing it *wrong* first.

This project is part of a learning exercise where we build a **messy, tightly coupled Laravel API** to clearly feel the pain points before refactoring in later days.

---

## 🛠️ Tasks

### 1️⃣ Create a New Laravel Project

```bash
laravel new task-api
cd task-api
```

---

### 2️⃣ Create Task Model & Migration

Generate the model and migration:

```bash
php artisan make:model Task -m
```

#### Database Fields

| Field       | Type     | Description              |
| ----------- | -------- | ------------------------ |
| id          | bigint   | Primary key              |
| title       | string   | Task title               |
| description | text     | Task description         |
| status      | string   | `pending` or `completed` |
| user_id     | bigint   | Owner of the task        |
| timestamps  | datetime | Laravel default          |

Example migration:

```php
Schema::create('tasks', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->text('description')->nullable();
    $table->string('status')->default('pending');
    $table->unsignedBigInteger('user_id');
    $table->timestamps();
});
```

Run migrations:

```bash
php artisan migrate
```

---

### 3️⃣ Create TaskController (❌ INTENTIONALLY BAD)

Generate controller:

```bash
php artisan make:controller TaskController
```

⚠️ **Important Rule:**

> Do **NOT** refactor. Everything goes into the controller.

#### Responsibilities (All Inside Controller)

* Request validation
* Business rules
* Database queries
* Status validation
* Fake notification sending

#### Example Responsibilities

* Create a task
* Mark task as completed
* Validate allowed statuses
* Simulate notification logic

Example (bad) controller behavior:

```php
public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string',
        'description' => 'nullable|string',
        'user_id' => 'required|integer',
    ]);

    $task = Task::create([
        'title' => $request->title,
        'description' => $request->description,
        'status' => 'pending',
        'user_id' => $request->user_id,
    ]);

    // Fake notification
    Log::info('Task created notification sent');

    return response()->json($task);
}
```

Everything is tightly coupled. Everything lives here. **Yes, it’s ugly — that’s the point.**

---

## ✅ Deliverables

* [x] Task can be created
* [x] Task can be marked as completed
* [x] Controller is messy and bloated

---

## 📝 End‑of‑Day Notes

**Pain Points Felt:**

* Controller is too big
* Business logic mixed with HTTP concerns
* Hard to test, hard to read, hard to maintain

---

🚀 **Next Step:** Refactor this mess using proper OOP, services, and clean architecture.

> *You can’t appreciate clean code until you’ve lived with bad code.* 😄
