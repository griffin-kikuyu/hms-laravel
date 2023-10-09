<?php

namespace App\Policies;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AppointmentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    // public function viewAny(User $user): bool
    // {
    //     //
    // }

    /**
     * Determine whether the user can view the model.
     */
    // public function view(User $user, Appointment $appointment): bool
    // {
    //     //
    // }

    /**
     * Determine whether the user can create models.
     */
    // public function create(User $user): bool
    // {
    //     //
    // }

    /**
     * Determine whether the user can update the model.
     */
    // public function update(User $user, Appointment $appointment): bool
    // {
    //     //
    // }

    /**
     * Determine whether the user can delete the model.
     */
    // public function delete(User $user, Appointment $appointment): bool
    // {
    //     //
    // }

    /**
     * Determine whether the user can restore the model.
     */
    // public function restore(User $user, Appointment $appointment): bool
    // {
    //     //
    // }

    /**
     * Determine whether the user can permanently delete the model.
     */
    // public function forceDelete(User $user, Appointment $appointment): bool
    // {
    //     //
    // }
//     public function view(User $user, Appointment $appointment)
// {
//     // Check if the user is an admin or the appointment belongs to the user
//     return $user->isAdmin() || $appointment->patient_id == $user->patient->id;
// }

// public function approve(User $user, Appointment $appointment)
// {
//     // Check if the user is a doctor and the appointment is assigned to them
//     return $user->isDoctor() && $appointment->doctor_id == $user->doctor->id;
// }

// public function delete(User $user, Appointment $appointment)
// {
//     // Only admins can delete appointments
//     return $user->isAdmin();
// }
}
