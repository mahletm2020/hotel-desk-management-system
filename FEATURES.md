# 🏨 Hotel Management System (HMS) - Feature Documentation

This document provides a detailed overview of the modules and features implemented in the system, along with their corresponding code locations.

---

## 🚀 Core Features & Business Logic

### 1. **Check-In & Check-Out Operations**
The system automates the transition between booking and active occupancy.

#### **Check-In (Pre-stay to Active)**
*   **Action**: Converts a **Reservation** into an active **Stay**.
*   **Logic**:
    *   Creates a `Stay` record linked to the `Guest`.
    *   Links the selected `Room` to the stay via `StayRoom`.
    *   **Room Status**: Automatically updates from `available` or `cleaning` to `occupied`.
*   **File**: [ReservationResource.php](file:///home/ziana/work/hms/back/app/Filament/Resources/ReservationResource.php) (Line 83 - `check_in` action)

#### **Check-Out (Active to Departure)**
*   **Action**: Finalizes the **Stay** and calculates the final bill.
*   **Logic**:
    *   **Auto-Calculation**: Calculates total duration (days) × Room base price.
    *   **Add-ons**: Aggregates all linked `ServiceCharges` (e.g., Room Service).
    *   **Room Status**: Automatically updates from `occupied` to `cleaning`.
*   **File**: [StayResource.php](file:///home/ziana/work/hms/back/app/Filament/Resources/StayResource.php) (Line 93 - `check_out` action)

---

## 📁 Detailed Module Breakdown

### 👤 Guest Management
*   **Description**: Full CRM for hotel guests.
*   **Files**: 
    *   Model: [Guest.php](file:///home/ziana/work/hms/back/app/Models/Guest.php)
    *   Resource: [GuestResource.php](file:///home/ziana/work/hms/back/app/Filament/Resources/GuestResource.php)
*   **Key Fields**: `first_name`, `last_name`, `email`, `phone`, `id_type`, `id_number`, `address`.

### 🛌 Room & Inventory Management
*   **Description**: Manage rooms, floors, and pricing categories.
*   **Files**:
    *   Models: [Room.php](file:///home/ziana/work/hms/back/app/Models/Room.php), [RoomType.php](file:///home/ziana/work/hms/back/app/Models/RoomType.php)
    *   Resources: [RoomResource.php](file:///home/ziana/work/hms/back/app/Filament/Resources/RoomResource.php), [RoomTypeResource.php](file:///home/ziana/work/hms/back/app/Filament/Resources/RoomTypeResource.php)
*   **Status Tracking**: `available` (Success), `occupied` (Danger), `cleaning` (Warning), `maintenance` (Gray).

### 📅 Reservation System
*   **Description**: Handles future bookings.
*   **Files**:
    *   Model: [Reservation.php](file:///home/ziana/work/hms/back/app/Models/Reservation.php)
    *   Resource: [ReservationResource.php](file:///home/ziana/work/hms/back/app/Filament/Resources/ReservationResource.php)
*   **Status Flow**: `pending` → `confirmed` → `checked_in`.

### 🏠 Stay Management
*   **Description**: The "Front Desk" hub for current guests.
*   **Files**:
    *   Model: [Stay.php](file:///home/ziana/work/hms/back/app/Models/Stay.php)
    *   Resource: [StayResource.php](file:///home/ziana/work/hms/back/app/Filament/Resources/StayResource.php)
*   **Relations**: Manages associated Rooms, Payments, and Service Charges via Relation Managers.

### 💰 Billing & Finance
*   **Description**: Tracking revenue and additional expenses.
*   **Files**:
    *   **Payments**: [PaymentResource.php](file:///home/ziana/work/hms/back/app/Filament/Resources/PaymentResource.php) (Log payments via Cash/Card/etc.)
    *   **Service Charges**: [ServiceChargeResource.php](file:///home/ziana/work/hms/back/app/Filament/Resources/ServiceChargeResource.php) (Add extra costs like Laundry or Mini-bar)

---

## 📊 Database Schema Summary

| Table | Purpose |
| :--- | :--- |
| `guests` | Personal data & identity verification. |
| `rooms` | Room availability & location. |
| `room_types` | Pricing & category definitions. |
| `reservations` | Pre-arrival booking data. |
| `stays` | Active guest records & final totals. |
| `stay_rooms` | Pivot table linking stays to rooms (supports multiple rooms per stay). |
| `service_charges`| Dynamic fees added during a stay. |
| `payments` | Transaction logs. |

---

## 🖥️ UI / Pages (Filament Admin)

All features are integrated into the **Filament Admin Panel** at `/admin`.
- **Primary Icons**: Uses Heroicons for visual navigation.
- **Dynamic Badges**: Statuses (Room Status, Stay Status, Reservation Status) are color-coded for quick scanning.
- **Modals**: Check-in and Check-out actions use confirmation modals to prevent accidental status changes.
