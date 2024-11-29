## Auth API Documentation


## Authentication Endpoints

### 1. Register User

**Endpoint:** `POST /api/register`  
**Description:** Registers a new user.

#### Request:
**Headers:**
```
Content-Type: application/json
```

**Body:**
```json
{
  "name": "Jane Doe",
  "email": "janedoe@example.com",
  "password": "password123",
  "password_confirmation": "password123"
}
```

#### Response (Success):
**Status Code:** `200 OK`
```json
{
    "status": true,
    "message": "User Created SUccessfully",
    "token": "6|2tOjwEfZeR3LWHiUBJV1y2ENMdqNo2lDqSfd4p2ld05df4bd"
}
```

#### Response (Validation Error):
**Status Code:** `422 Unprocessable Entity`
```json
{
  "message": "The given data was invalid.",
  "errors": {
    "email": ["The email has already been taken."]
  }
}
```

---

### 2. Login User

**Endpoint:** `POST /api/login`  
**Description:** Authenticates a user and provides an access token.

#### Request:
**Headers:**
```
Content-Type: application/json
```

**Body:**
```json
{
  "email": "janedoe@example.com",
  "password": "password123"
}
```

#### Response (Success):
**Status Code:** `200 OK`
```json
{
    "status": true,
    "message": "Logged in SUccessfully",
    "token": "7|QOaucfx3Y9oM0wbW04aQv7p9PuItGMrHFWiv5uNA5b6e7d9e"
}
```

#### Response (Error - Invalid Credentials):
**Status Code:** `401 Unauthorized`
```json
{
  "error": "Unauthorized"
}
```

#### Response (Validation Error):
**Status Code:** `422 Unprocessable Entity`
```json
{
  "message": "The given data was invalid.",
  "errors": {
    "email": ["The email field is required."],
    "password": ["The password field is required."]
  }
}
```

---

### 3. Logout User

**Endpoint:** `POST /api/logout`  
**Description:** Logs out the authenticated user by revoking their token.

#### Request:
**Headers:**
```
Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...
Content-Type: application/json
```

#### Response (Success):
**Status Code:** `200 OK`
```json
{
  "message": "Successfully logged out"
}
```

#### Response (Error - Not Authenticated):
**Status Code:** `401 Unauthorized`
```json
{
  "message": "Unauthenticated."
}
```

---



### 4. Wallet Management
### 1. Fund Wallet
**Endpoint:** `POST /api/wallet/fund`
**Description:** Adds funds to the user's wallet.

#### Request (Authenticated):
```json

{
  "amount": 1000,
  "payment_method": "credit_card"
}
```
#### Response (Success):
```json

{
  "success": true,
  "message": "Wallet funded successfully.",
  "data": {
    "balance": 2000
  }
}
```
#### Response (Error):
```json

{
  "success": false,
  "message": "Failed to fund wallet.",
  "errors": {
    "amount": ["Amount must be a positive value."]
  }
}
```
### 2. Wallet Balance
**Endpoint:** `GET /api/wallet/balance`
**Description:** Gets balance of the user's wallet.

#### Response (Success):
```json

{
  
  {
    "balance": 2000
  }
}

```

### 5. Bill Payments
### 1. Purchase Airtime
**Endpoint:** `POST /api/purchase/airtime`
**Description:** Purchases airtime for a specified mobile number.

#### Request (Authenticated):
```json

{
    "amount": 500,
    "type": "airtime",
    "details": {
        "phone_number": "1234567890",
        "provider": "MTN"
    }
}

```

#### Response (Success):
```json

{
    "message": "Purchase successful!"
}

```

#### Error Responses

1. **Validation Errors (422)**:  
   If the input is invalid, you will receive a response like this:
   ```json
   {
       "message": "The given data was invalid.",
       "errors": {
           "amount": ["The amount must be at least 1."],
           "type": ["The type field is required."]
       }
   }
   ```

2. **Unauthorized Access (401)**:  
   If the user is not authenticated:
   ```json
   {
       "message": "Unauthenticated."
   }
   ```

3. **Insufficient Wallet Balance (Custom Error)**:  
   If you add a check for the wallet balance and the balance is insufficient, return a custom error:
   ```php
   if ($wallet->balance < $validated['amount']) {
       return response()->json(['message' => 'Insufficient wallet balance.'], 400);
   }
   ```
   Response:
   ```json
   {
       "message": "Insufficient wallet balance."
   }
   ```

---


---

#### Endpoint:
```http
POST /api/bills
```

#### Headers:
```json
Authorization: Bearer your_access_token
Content-Type: application/json
```

#### Body:
```json
{
    "type": "electricity",
    "amount": 1200,
    "meta": {
        "account_number": "1234567890",
        "provider": "PowerCompany",
        "billing_month": "November 2024"
    }
}
```

---

### Sample Response

#### Success Response (201):
```json
{
    "message": "Bill payment successful!"
}
```

---

### Possible Error Responses

1. **Validation Errors (422)**:  
   If the input data is invalid:
   ```json
   {
       "message": "The given data was invalid.",
       "errors": {
           "type": ["The type field must be one of airtime, electricity, data."],
           "amount": ["The amount must be at least 1."]
       }
   }
   ```

2. **Insufficient Wallet Balance (Custom Error)**:  
   Response:
   ```json
   {
       "message": "Insufficient wallet balance."
   }
   ```

3. **Unauthorized Access (401)**:  
   If the user is not authenticated:
   ```json
   {
       "message": "Unauthenticated."
   }
   ```

---

### Sample Database Entries Created

1. **Bill Entry**:
   ```json
   {
       "id": 1,
       "user_id": 1,
       "type": "electricity",
       "amount": 1200,
       "reference": "bill_6495b8c2c3",
       "meta": {
           "account_number": "1234567890",
           "provider": "PowerCompany",
           "billing_month": "November 2024"
       },
       "status": "success",
       "created_at": "2024-11-29T10:30:00Z"
   }
   ```

2. **Transaction Entry**:
   ```json
   {
       "id": 1,
       "user_id": 1,
       "wallet_id": 1,
       "type": "debit",
       "amount": 1200,
       "description": "Bill payment: electricity",
       "created_at": "2024-11-29T10:30:00Z"
   }
   ```

---

---

### 1. **Get All Transactions**

#### Endpoint:
```http
GET /api/transactions
```

#### Headers:
```json
Authorization: Bearer your_access_token
```

---

#### Sample Response (200):
```json
{
    "transactions": [
        {
            "id": 1,
            "user_id": 1,
            "wallet_id": 2,
            "type": "debit",
            "amount": 500,
            "description": "Bill payment: electricity",
            "created_at": "2024-11-29T10:00:00Z",
            "updated_at": "2024-11-29T10:00:00Z"
        },
        {
            "id": 2,
            "user_id": 1,
            "wallet_id": 2,
            "type": "credit",
            "amount": 1000,
            "description": "Wallet top-up",
            "created_at": "2024-11-28T15:00:00Z",
            "updated_at": "2024-11-28T15:00:00Z"
        }
    ]
}
```

---

### 2. **Get a Specific Transaction**

#### Endpoint:
```http
GET /api/transactions/{id}
```

#### Example:
```http
GET /api/transactions/1
```

#### Headers:
```json
Authorization: Bearer your_access_token
```

---

#### Sample Response (200):
```json
{
    "transaction": {
        "id": 1,
        "user_id": 1,
        "wallet_id": 2,
        "type": "debit",
        "amount": 500,
        "description": "Bill payment: electricity",
        "created_at": "2024-11-29T10:00:00Z",
        "updated_at": "2024-11-29T10:00:00Z"
    }
}
```

---

### Possible Error Responses

1. **Unauthorized Access (401)**:
   If the user is not authenticated:
   ```json
   {
       "message": "Unauthenticated."
   }
   ```

2. **Transaction Not Found (404)**:
   If the `id` provided does not belong to any transaction for the authenticated user:
   ```json
   {
       "message": "No query results for model [App\\Models\\Transaction]."
   }
   ```

---


## Notes

1. **Authorization:**  
   - The `Bearer` token is required in the `Authorization` header for the `logout` endpoint.  
   - Tokens are provided upon successful login and should be stored securely by the client.

2. **Error Handling:**  
   - All validation errors return a `422` status code with details in the `errors` field.
   - Unauthorized access returns a `401` status code.

3. **Testing in Postman:**  
   - For `logout`, ensure the token from the `login` response is used in the `Authorization` header.
   - Use `Content-Type: application/json` for all requests.

---

