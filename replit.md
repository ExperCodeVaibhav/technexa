# TECHNEXA - Web Agency Website

## Overview
TECHNEXA is a modern web agency website built with PHP, SQLite, and TailwindCSS. The project showcases a technology and marketing agency's services, portfolio, and contact capabilities.

## Project Architecture
- **Frontend**: HTML/CSS/JavaScript with TailwindCSS (via CDN)
- **Backend**: PHP 8.2
- **Database**: SQLite (technexa.sqlite)
- **Structure**:
  - `/public/` - Public-facing website pages
  - `/admin/` - Admin panel (not fully implemented)
  - `/config/` - Database configuration
  - `/assets/` - Static files (images, videos)

## Current State
- ✅ PHP development server running on port 5000
- ✅ Database connection working with auto-created tables
- ✅ Main website pages loading successfully
- ✅ Static assets being served correctly
- ✅ Deployment configuration set for production

## Database Schema
The SQLite database includes tables for:
- `users` - Admin authentication
- `messages` - Contact form submissions  
- `projects` - Portfolio case studies
- `clients` - Client testimonials
- `blog_posts` - Blog content

Default admin credentials: admin / Technexa@123

## Development Setup
- Server runs with: `php -S 0.0.0.0:5000 -t public`
- Document root is `/public/` directory
- Database auto-initializes on first connection

## Recent Changes (September 22, 2025)
- ✅ Imported GitHub project and restructured files
- ✅ Installed PHP 8.2 module
- ✅ Configured PHP development server workflow
- ✅ Verified database connectivity and table creation
- ✅ Set up deployment configuration for production
- ✅ Tested all main functionality successfully

## Notes
- Uses TailwindCSS CDN (shows warning in console for production use)
- Video hero section requires hero.mp4 file
- Admin panel files exist but appear empty - may need implementation
- Contact form and project management functionality built-in