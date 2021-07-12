<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

## Coding Assessment - VOSCO Technologies
Create a single web page that does the following.
a) List the recorded cam videos with it's title, name and video preview.
b) Add New cam recording , by simply opening in the same browser window.
c) In place editing of fields.
d) Use DataTables for listing records.
e) All ajax based, no page refresh.

Platform used - Laravel

To follow along, this application has been documented as an article. you can checkout here.

Set up

To set up this project, first clone the repositiory

$ git clone https://github.com/yadavendra15/vosco-task.git
Change your working directory into the project directory

$ cd vosco-task
Then install dependencies using Composer

composer install

Run the application with the following command

$ php artisan serve

Remember to visit http://127.0.0.1:8000/medias

I've set the limit of recording to save the time and space. Currently this is set to 5 sec. We can extend it easily.

I hope you liked it. :)

# Screenshot : 1 (DataTables Listing)
<p align="center"><img src="https://github.com/yadavendra15/vosco-task/blob/main/Screenshot%20(120).png" width="400"></a></p>

    
# Screenshot : 2 (New Webcam Recording)
<p align="center"><img src="https://github.com/yadavendra15/vosco-task/blob/main/Screenshot%20(121).png" width="400"></a></p>


# Screenshot : 3 (Started Recording)
<p align="center"><img src="https://github.com/yadavendra15/vosco-task/blob/main/Screenshot%20(122).png" width="400"></a></p>
    

# Screenshot : 4 (Show Save and Download Button)
<p align="center"><img src="https://github.com/yadavendra15/vosco-task/blob/main/Screenshot%20(123).png" width="400"></a></p>

Built With
Laravel - The PHP Framework For Web Artisans.

Mysql - A relational database management system.


<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 1500 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
