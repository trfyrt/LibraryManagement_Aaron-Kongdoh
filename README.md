<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## About the Project
The Laravel Library Management is an example project that demonstrates how to develop applications using the Laravel 11 framework. 

## Models
- **Books**: Consists of `title`, `author`, `publisher`, `year`, `type` (Printed book or Ebook), and `is_approved` (Request status) attributes.
- **CDs**: Consists of `title`, `artist`, `genre`, `stock` and `is_approved` (Request status) attributes.
- **Journals**: Consists of `title`, `author`, `publish_date`, `abstract` and `is_approved` (Request status) attributes.
- **Newspapers**: Consists of `title`, `publisher` (Kompas, Tribun Timur, or Fajar), `publish_date`, `is_available` and `is_approved` (Request status) attributes.

## User Role
- **Admin** can add/remove librarian and has authority to approve or reject collection update requested by the librarian.
- **Librarian** can manage library inventory (Create, Read, Update, Delete).

## Contact
If you have any questions or issues with this project, please contact Aaron Kongdoh at abenedict01@student.ciputra.ac.id.
