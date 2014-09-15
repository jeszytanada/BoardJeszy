<?php
class AppException extends Exception
{

}

class ValidationException extends AppException
{

}

class UserNotFoundException extends AppException
{

}

class UserAlreadyExistsException extends AppException
{

}
class PageNotFoundException extends AppException
{

}
class RecordNotFoundException extends AppException
{

}