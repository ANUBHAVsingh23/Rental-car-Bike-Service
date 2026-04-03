# Safar Rentals - Car and Bike Rental Platform
## Overview
**Safar Rentals** is a full-stack web application that enables clients to seamlessly rent cars and bikes online. The platform streamlines the vehicle rental process, allowing users to browse inventory, check availability, and complete bookings with automatic form population and real-time conflict detection.

### Technology Stack
- **Frontend:** HTML5, CSS3, JavaScript (with AJAX for real-time validations)
- **Backend:** PHP (server-side processing)
- **Database:** MySQL (booking and user data storage)
- **Responsive Design:** Mobile-friendly layout that adapts to all screen sizes

---

## Core Features

### User Experience
✓ **Responsive Design** - Seamlessly adapts to desktop, tablet, and mobile devices  
✓ **Navigation Bar** - Easy-to-use menu with agency contact details always visible  
✓ **Image Slideshow** - Attractive auto-rotating carousel on home page  
✓ **Enquiry Forms** - Contact forms with validation for user inquiries  

### Vehicle Browsing & Management
✓ **Dual Catalog** - Browse cars and bikes separately with full details, images, and pricing  
✓ **Real-Time Availability** - AJAX checks prevent double-booking on same date  
✓ **Auto-Filled Forms** - Vehicle details automatically populate on rental form  
✓ **Date-Based Filtering** - Users select rental dates with availability verification  

### Booking & Data Management
✓ **Secure Booking Form** - Collects user details with validation (incomplete entry detection)  
✓ **Document Upload** - Driving license upload integration  
✓ **Database Storage** - All bookings persisted for agency management  
✓ **Confirmation Messages** - Instant feedback on successful bookings  

### Agency Information
✓ **Service Pages** - Dedicated pages for CAR RENTAL SERVICE and ONE WAY DROP SERVICE  
✓ **Terms & Conditions** - Clear terms page for legal compliance  
✓ **Corporate Services** - Wedding rentals, event vehicles  
✓ **Location Details** - Pickup locations (Punjab, LPU region)  
✓ **Contact Info** - Centralized footer with address, phone, and email  

### Additional Features
✓ **Feedback System** - Users can submit feedback stored in database  
✓ **Event Rentals** - Wedding and event vehicle rental options  
✓ **Multiple Service Types** - Self-drive, rental, corporate event services  

---

## Project Structure

### Main Pages

| File | Purpose | Description |
|------|---------|-------------|
| **index.php** | Home Page | Landing page with slideshow, service overview, and main navigation hub |
| **cars.php** | Car Rentals | Browse and select from available cars with pricing and specifications |
| **bikes.php** | Bike Rentals | Browse and select from available bikes |
| **rental.php** | Car Rental Service | Dedicated CAR RENTAL SERVICE page with booking form |
| **one.php** | One-Way Drop Service | ONE WAY DROP SERVICE page with special pricing/terms |
| **contact.php** | Contact Us | Contact form and agency location information |
| **feedback.php** | User Feedback | Feedback submission form with database storage |
| **terms.php** | Terms & Conditions | Legal terms and conditions for users |
| **wed.php** | Wedding Rentals | Luxury wedding vehicle rental options |
| **event.php** | Event Services | Corporate and event vehicle rental services |
| **corporate.php** | Corporate Services | Corporate fleet rental options |
| **self.php** | Self-Drive Services | Self-drive rental information and booking |

### Supporting Files

| File | Purpose |
|------|---------|
| **script.js** | Client-side JavaScript - Form validations, AJAX calls, dynamic interactions |
| **poppins.css** | Font stylesheet - Poppins font family for typography |
| **montserrat.css** | Font stylesheet - Montserrat font family for headings |
| **checkdate.php** | Backend utility - AJAX handler for availability/date verification |
| **images/** | Asset directory - Contains logos, service images, icons, screenshots |
| **License.txt** | Project license file |

---

## Contact Information

### Agency Details
**Address:** Punjab, LPU  
**Phone:** +91-7380718141  
**Email:** singh.anubhav3945@gmail.com  

*These contact details are centralized in the footer of every page for easy user access.*

---

## Recent Updates

### Navigation Fixes (April 2026)
- Fixed broken "Home" navigation links across all pages
- Changed `Home.php` references to `index.php` to resolve 404 errors
- Service links now properly navigate to `index.php#service` anchor

### Footer Standardization (April 2026)
- Unified footer contact information across all pages
- Standardized address to: **Punjab, LPU**
- Standardized phone number to: **+91-7380718141**
- Standardized email to: **singh.anubhav3945@gmail.com**

---

## Installation & Setup

### Prerequisites
- PHP 7.0 or higher
- MySQL database
- Apache web server (XAMPP recommended for local development)

### Steps
1. Place project folder in `htdocs` (XAMPP) or web root
2. Create MySQL database for bookings/users
3. Configure database connection in PHP files as needed
4. Access via `http://localhost/phpproject/index.php`

---

## Browser Compatibility
- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile browsers (iOS Safari, Chrome Mobile)

---

## Screenshots

![Home](/images/Home.png)
![Cars](/images/cars.png)
![Bikes](/images/bikes.png)
![Contact](/images/contact.png)
![Feedback](/images/feedback.png)

---

## License
See `License.txt` for license information.

---
*Last Updated: April 2026*
