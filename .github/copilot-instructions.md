# AntriYuk - AI Coding Agent Instructions

## Project Overview
**AntriYuk** is a Laravel 12 Queue Management System with real-time WebSocket integration via Laravel Reverb. The system allows locations (service points) to manage queues with ticket-based ordering, estimated wait times, and live updates for both customers and operators.

## Tech Stack
- **Backend**: Laravel 12, PHP 8.2+
- **Real-time**: Laravel Reverb (WebSocket server)
- **Frontend**: Tailwind CSS v4, Vite 7, Alpine.js (via CDN)
- **Testing**: Pest PHP v4 (not PHPUnit directly)
- **Database**: SQLite (default), MySQL/MariaDB supported
- **Broadcasting**: Public channels for queue updates

## Quick Commands

```bash
# First-time setup (installs deps, creates .env, runs migrations, builds assets)
composer setup

# Development server (runs Laravel server + queue + Vite concurrently)
composer dev

# Start WebSocket server (run in separate terminal)
php artisan reverb:start

# Run tests
composer test
# Or directly: php artisan test
```

## System Architecture

### Core Domain Models
| Model | Purpose |
|-------|---------|
| `Location` | Service points (e.g., Customer Service, Payment Counter) |
| `Counter` | Service windows within a location, assigned to operators |
| `Ticket` | Queue tickets with status tracking (waiting/calling/serving/completed/skipped/cancelled) |
| `User` | Supports roles: admin, operator, viewer |

### Key Relationships
- Location → hasMany Counters, Tickets, Users (operators)
- Counter → belongsTo Location, hasMany Tickets
- Ticket → belongsTo Location, Counter, User (served_by)
- User → belongsTo Location (for operators)

### User Roles
- **Admin**: Full system access, manages locations/counters/users
- **Operator**: Manages queue at assigned location, calls/serves tickets
- **Viewer**: Default role, can view queues and get tickets

## Project Structure

| Directory | Purpose |
|-----------|---------|
| `app/Http/Controllers/` | LocationController, TicketController, OperatorController, AdminController, AuthController |
| `app/Http/Middleware/` | EnsureUserIsAdmin, EnsureUserIsOperator |
| `app/Models/` | Location, Counter, Ticket, User with queue logic methods |
| `app/Events/` | TicketCreated, TicketCalled, TicketStatusChanged, QueueUpdated |
| `database/migrations/` | Users, locations, counters, tickets tables |
| `database/factories/` | Factories for all models with states |
| `resources/views/` | Blade templates with Indonesian UI text |
| `routes/web.php` | Public, auth, operator, admin route groups |
| `tests/Feature/` | LocationTest, OperatorTest, AdminTest, AuthTest |

## Coding Patterns

### Models
- Always use `HasFactory` trait for factory support
- Define `$fillable` arrays explicitly (no `$guarded = []`)
- Use `casts()` method for attribute casting (Laravel 12 pattern)
- Include business logic methods (e.g., `Ticket::createTicket()`, `Location::getEstimatedWaitTime()`)
```php
protected function casts(): array {
    return ['is_active' => 'boolean', 'called_at' => 'datetime'];
}
```

### Events & Broadcasting
- Events implement `ShouldBroadcast` interface
- Use public channels: `location.{id}`, `ticket.{id}`
- Broadcast ticket status changes for real-time UI updates
```php
public function broadcastOn(): array {
    return [new Channel('location.' . $this->ticket->location_id)];
}
```

### Testing (Pest PHP)
- `RefreshDatabase` trait enabled for Feature tests
- Use factory states: `Ticket::factory()->waiting()`, `User::factory()->admin()`
- Test HTTP responses and database assertions
```php
test('operator can call next ticket', function () {
    $operator = User::factory()->create(['role' => 'operator', 'location_id' => $location->id]);
    $this->actingAs($operator)->post('/operator/call-next');
    $this->assertDatabaseHas('tickets', ['status' => 'calling']);
});
```

### Frontend
- Tailwind v4 uses `@import 'tailwindcss'` syntax in `resources/css/app.css`
- UI in Indonesian (Bahasa Indonesia)
- Simple, flat design (no gradients)
- Echo.js for WebSocket subscriptions in browser
- Include assets with `@vite(['resources/css/app.css', 'resources/js/app.js'])`

### Middleware
- `EnsureUserIsAdmin` - Returns 403 if not admin role
- `EnsureUserIsOperator` - Returns 403 if not operator role

### Database
- Default: SQLite at `database/database.sqlite`
- Tests use in-memory SQLite (`:memory:`)
- Migration naming: descriptive snake_case after timestamp
- Ticket number format: `{LOCATION_CODE}-{###}` (e.g., CS-001)

## Key Features

### Queue Management
- Customers take tickets at locations
- Operators call next ticket from their counter
- Real-time queue position and estimated wait time
- Display boards for waiting room screens

### Ticket Lifecycle
1. **waiting** - Customer received ticket
2. **calling** - Operator calling ticket number
3. **serving** - Customer at counter being served
4. **completed** - Service finished
5. **skipped** - Customer didn't respond
6. **cancelled** - Ticket cancelled

### Wait Time Calculation
```php
// In Location model
public function getEstimatedWaitTime(): int {
    $activeCounters = $this->counters()->where('is_active', true)->count();
    $waitingCount = $this->tickets()->where('status', 'waiting')->count();
    $averageTime = $this->average_service_time ?? 5;
    return $activeCounters > 0 
        ? ceil($waitingCount / $activeCounters) * $averageTime 
        : $waitingCount * $averageTime;
}
```

## Testing Configuration
- Tests run with `DB_CONNECTION=sqlite` and `DB_DATABASE=:memory:`
- Queue runs synchronously in tests (`QUEUE_CONNECTION=sync`)
- Cache uses array driver in tests (`CACHE_STORE=array`)
- RefreshDatabase enabled in `tests/Pest.php`

## Test Accounts (from seeder)
| Role | Email | Password |
|------|-------|----------|
| Admin | admin@antriyuk.test | password |
| Operator | operator-cs@antriyuk.test | password |
| Operator | operator-pay@antriyuk.test | password |
| Operator | operator-reg@antriyuk.test | password |

## When Adding Features
1. Create migration: `php artisan make:migration create_<table>_table`
2. Create model: `php artisan make:model <Name> -f` (includes factory)
3. Create event if real-time needed: `php artisan make:event <Name>`
4. Create controller: `php artisan make:controller <Name>Controller`
5. Add middleware if role-restricted
6. Add routes in `routes/web.php` with appropriate middleware group
7. Write Pest tests in `tests/Feature/`
8. Update seeder if initial data needed
