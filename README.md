# atriumcampus

#Requirements

The server is running Linux / Apache / PHP / MySQL.

There is a single table 'test' in the database named 'guillermo_test' with the following columns:

```id              int(11)    
first_name      varchar(30)
middle_initial  varchar(1)  
last_name       varchar(30)
loan            float(10,2)
value           float(10,2)
```

For the project, please use PHP (with or without a framework) to create a web page which displays a list of all the rows in the table 'test'. It should also include an additional column titled LTV (Loan-To-Value) which is the 'loan' divided by the 'value' converted to a percentage. It should also have the ability to edit and/or delete existing rows, and to create a new row.

When editing an existing row or creating a new row, an additional field should be on the page titled LTV (Loan-To-Value). This field should be read only with the value being the 'loan' divided by the 'value' converted to a percentage. This LTV value should be computed dynamically using JavaScript so that it is updated when the page loads and after the values for 'loan' or 'value' have been modified by the user on the page. The "submit" of the form should cause the values to be updated for existing rows, and inserted for new rows, then return the user back to the first page with a listing of all rows.
