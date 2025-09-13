<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <!-- Title and Description -->
        <title>{{ config('app.name', 'New Radiant SC') }} - Pride of Maldivian Football</title>
        <meta name="description" content="New Radiant Sports Club - Established 1979. Join our academy, support our first team, and be part of Maldivian football history.">
        <meta name="keywords" content="New Radiant SC, Maldives football, football academy, Maldivian football, sports club, football training">
        
        <!-- Favicon -->
        <link rel="icon" type="image/svg+xml" href="/favicon.svg">
        <link rel="icon" type="image/x-icon" href="/favicon.ico">
        <link rel="apple-touch-icon" href="/favicon.svg">
        
        <!-- Open Graph Meta Tags -->
        <meta property="og:title" content="New Radiant SC - Pride of Maldivian Football">
        <meta property="og:description" content="Established 1979. Join our academy, support our first team, and be part of Maldivian football history.">
        <meta property="og:image" content="{{ url('/og-image.svg') }}">
        <meta property="og:image:width" content="1200">
        <meta property="og:image:height" content="630">
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url('/') }}">
        <meta property="og:site_name" content="New Radiant SC">
        
        <!-- Twitter Card Meta Tags -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="New Radiant SC - Pride of Maldivian Football">
        <meta name="twitter:description" content="Established 1979. Join our academy, support our first team, and be part of Maldivian football history.">
        <meta name="twitter:image" content="{{ url('/og-image.svg') }}">
        
        <!-- Additional Meta Tags -->
        <meta name="author" content="New Radiant Sports Club">
        <meta name="robots" content="index, follow">
        <meta name="theme-color" content="#1e40af">
        
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        
        <!-- Vite Assets -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
<body>
    <div id="app"></div>
    </body>
</html>
