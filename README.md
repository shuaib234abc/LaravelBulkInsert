# Bulk Insert

This is a customized web application to demonstrate bulk data insert (from Excel file) in Laravel.


## Following libraries have been used in this applications
1. Laravel 8.12 ( https://laravel.com/ ) ... MIT license
2. Laravel Excel 3.1.29 (https://laravel-excel.com/) ... MIT license
3. jQuery 3.6.0 (https://jquery.com/) ... MIT license
4. Toastr 2.1.4 (https://github.com/CodeSeven/toastr) ... MIT license
5. For UI / UX design, I have taken CoreUI v3.2.0 (Bootstrap 4 Admin template, https://coreui.io)


## Please check the wiki folder in project root for various documentation related to the initial design of this application.
---- Inside the wiki folder I have tried to credit authors whenever I used some code snippets from online blogs / tutorials, etc.


## Running the application
1. Please change the post_max_size and upload_max_filesize values in php.ini to support 42 MB or greater file size
2. Uploaded files are stored in "\storage\app\public\uploads". This is specified in UploadController.php, line 34


## Branch information
1. feature/straightforward : This branch demonstrates straight forward bulk insert approach. The code here failed for a input file of around 40 MB.
2. feature/optimized_for_large_file : This branch demonstrates a way to insert data in very large files.
3. master : same as branch 2


## Dataset attribution
The dataset available for download in the main application page has been taken from : https://github.com/duyet/bruteforce-database
Author: Van-Duyet Le
License : MIT (https://github.com/duyet/bruteforce-database/blob/master/LICENSE)
The full license for this dataset is given below:
-------- ----------------- -------- Start of dataset license ----- -------- -------------------
The MIT License (MIT)

Copyright (c) 2015 Van-Duyet Le

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
-------- ----------------- -------- End of dataset license ----- -------- -------------------
