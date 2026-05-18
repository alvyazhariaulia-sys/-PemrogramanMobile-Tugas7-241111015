package com.utama.aplikasiloginsederhana3a

import retrofit2.Response
import retrofit2.http.Body
import retrofit2.http.DELETE
import retrofit2.http.GET
import retrofit2.http.POST
import retrofit2.http.PUT
import retrofit2.http.Query

interface ApiService {

    // =========================
    // EVENT ENDPOINTS
    // =========================

    // GET semua event
    @GET("events.php")
    suspend fun getAllEvents():
            Response<ApiResponse<List<EventApiModel>>>

    // GET event berdasarkan ID
    @GET("events.php")
    suspend fun getEventById(
        @Query("id")
        id: Int
    ): Response<ApiResponse<EventApiModel>>

    // POST tambah event baru
    @POST("events.php")
    suspend fun addEvent(
        @Body
        event: EventRequest
    ): Response<ApiResponse<Map<String, Int>>>

    // PUT update event
    @PUT("events.php")
    suspend fun updateEvent(
        @Query("id")
        id: Int,

        @Body
        event: EventRequest
    ): Response<ApiResponse<Unit>>

    // DELETE event
    @DELETE("events.php")
    suspend fun deleteEvent(
        @Query("id")
        id: Int
    ): Response<ApiResponse<Unit>>


    // =========================
    // AUTH ENDPOINTS
    // =========================

    // LOGIN
    @POST("auth.php")
    suspend fun login(

        @Query("action")
        action: String = "login",

        @Body
        request: LoginRequest

    ): Response<ApiResponse<UserApiModel>>

    // REGISTER
    @POST("auth.php")
    suspend fun register(

        @Query("action")
        action: String = "register",

        @Body
        request: RegisterRequest

    ): Response<ApiResponse<Map<String, Int>>>
}
