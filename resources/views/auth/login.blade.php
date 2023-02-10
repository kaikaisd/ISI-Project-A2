<!-- login.blade.php -->
@extends('layouts.app')
<div>
    <!-- error message -->
    <v-alert
        v-if="error"
        :value="error"
        type="error"
        dismissible
        transition="scale-transition"
        @input="error = false"
    </v-alert>
</div>