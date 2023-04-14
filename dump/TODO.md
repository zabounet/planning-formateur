# My framework using MVC for OOP PHP programming.

## It is ready to use as is, but don't forget a few things :

- The admin part needs the user session to have a "permission" int key in order to grant you access.

- You need to make each table you want to interact with a class and list all of their columns as private attributes in the model folder.

- Every class has to be name like this : ***`ClassnameFoldername.php`*** example : ***`UserModel.php`***.

- The view folder does not contain any class and is rendered using the render method in ***`Controller.php`***.

- This MVC uses a rooter in order to put always redirect to the ***`index.php`*** page in the ***`public`*** folder. it takes every words following the index as parameters, interpreted as ***`Controller`***, ***`method`*** and ***`parameters`*** if any are required by the method. **Therefore, it is not adapted if the client is asking for separate pages on his website**.

- the .htaccess file content might change depending on the server. It is currently set for APACHE.

- Numerous verifications needs to be added, especially to the rooter files that is incomplete but functionnal.

- Form verifications are also incomplete and needs to be completed.

- You can create as many templates as needed

- Make sure to make the server point to the ***`public`*** folder by default.