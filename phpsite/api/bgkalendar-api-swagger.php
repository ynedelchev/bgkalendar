<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE, PUT, PATCH, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, api_key, Authorization");
?>
{
    "swagger": "2.0",
    "info": {
        "description": "Application Programming Interface (API) that allows calculation of dates in the Ancient Bulgarian Calendar or the Modern Gregoria/Julian Calendar also conversion of a date from one calendar to the other.",
        "version": "0.1.0",
        "title": "Bulgarian Calendar Project (bgkalendar.com)",
        "termsOfService": "http://swagger.io/terms/",
        "contact": {
            "email": "yordan.nedelchev@hotmail.com"
        },
        "license": {
            "name": "Custom License",
            "url": "https://opensource.org/licenses/MIT"
        }
    },
    "host": "bgkalendar.com",
    "basePath": "/api/v0/calendars",
    "tags": [
       {
        "name": "bulgarian",
        "description": "Work with Ancient Bulgarian Calendar"
       },
       {
        "name": "gregorian",
        "description": "Work with Modern Gregorian Calendar"
       }
    ],
    "schemes": [
        "https"
    ],
    "paths": {
        "/bulgarian/dates/today": {
            "get": {
                "tags": ["bulgarian"],
                "summary": "Get current date in Ancient Bulgarian Calendar and convert it to the MOdern Gregorian Calendar",
                "description": "Get current date of today in the Ancient Bulgarian Calendar.",
                "produces": ["application/json"],
                "responses": {
                  "200": {
                    "description": "OK", 
                    "content": {
                      "schema": {
                         "type": "object"
                      }
                    }
                  }
                }
            }
        },
        "/bulgarian/model": {
            "get": {
                "tags": ["bulgarian"],
                "summary": "Describes the structure of the Ancient Bulgarian Calendar.",
                "description": "Model of Ancient Bulgarian Calendar",
                "produces": ["application/json"],
                "responses": {
                  "200": {
                    "description": "OK", 
                    "content": {
                      "schema": {
                         "type": "object"
                      }
                    }
                  }
                }
            }
        },
        "/gregorian/dates/today": {
            "get": {
                "tags": ["gregorian"],
                "summary": "Get current date in Modern Gregorian Calendar and converts it into the corresponding date in the Ancient Bulgarian Calendar",
                "description": "Get current date of today in the Modern Gregorian Calendar.",
                "produces": ["application/json"],
                "responses": {
                  "200": {
                    "description": "OK", 
                    "content": {
                      "schema": {
                         "type": "object"
                      }
                    }
                  }
                }
            }
        },
        "/gregorian/model": {
            "get": {
                "tags": ["gregorian"],
                "summary": "Describes the structure of the Modern Gregorian Calendar.",
                "description": "Model of Greforian Calendar",
                "produces": ["application/json"],
                "responses": {
                  "200": {
                    "description": "OK", 
                    "content": {
                      "schema": {
                         "type": "object"
                      }
                    }
                  }
                }
            }
        }
    }
}
