package com.utama.aplikasiloginsederhana3a

import com.google.gson.annotations.SerializedName

// =========================
// RESPONSE API UMUM
// =========================

data class ApiResponse<T>(

    @SerializedName("success")
    val success: Boolean,

    @SerializedName("message")
    val message: String,

    @SerializedName("data")
    val data: T?
)


// =========================
// MODEL EVENT DARI API
// =========================

data class EventApiModel(

    @SerializedName("id")
    val id: Int,

    @SerializedName("name")
    val name: String,

    @SerializedName("date")
    val date: String,

    @SerializedName("location")
    val location: String,

    @SerializedName("price")
    val price: Int,

    @SerializedName("description")
    val description: String?
) {

    // Konversi API Model -> Local Model
    fun toEvent(): Event = Event(
        id = id,
        name = name,
        date = date,
        location = location,
        price = price
    )
}


// =========================
// MODEL USER DARI API
// =========================

data class UserApiModel(

    @SerializedName("id")
    val id: Int,

    @SerializedName("username")
    val username: String,

    @SerializedName("email")
    val email: String,

    @SerializedName("phone")
    val phone: String?
)


// =========================
// REQUEST LOGIN
// =========================

data class LoginRequest(

    @SerializedName("username")
    val username: String,

    @SerializedName("password")
    val password: String
)


// =========================
// REQUEST REGISTER
// =========================

data class RegisterRequest(

    @SerializedName("username")
    val username: String,

    @SerializedName("password")
    val password: String,

    @SerializedName("email")
    val email: String,

    @SerializedName("phone")
    val phone: String = ""
)


// =========================
// REQUEST EVENT BARU
// =========================

data class EventRequest(

    @SerializedName("name")
    val name: String,

    @SerializedName("date")
    val date: String,

    @SerializedName("location")
    val location: String,

    @SerializedName("price")
    val price: Int,

    @SerializedName("description")
    val description: String = ""
)
