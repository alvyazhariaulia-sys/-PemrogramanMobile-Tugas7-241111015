<?php

require_once 'config.php';

setHeaders();

$method = $_SERVER['REQUEST_METHOD'];

$id = isset($_GET['id']) ? (int) $_GET['id'] : null;

switch ($method) {

    // =========================
    // GET
    // =========================
    case 'GET':

        $conn = getConnection();

        if ($id) {

            $stmt = $conn->prepare(
                "SELECT * FROM events WHERE id = ?"
            );

            $stmt->bind_param("i", $id);

            $stmt->execute();

            $result = $stmt->get_result();

            $event = $result->fetch_assoc();

            if ($event) {

                successResponse($event);

            } else {

                errorResponse(
                    "Event tidak ditemukan",
                    404
                );
            }

        } else {

            $result = $conn->query(
                "SELECT * FROM events ORDER BY date ASC"
            );

            $events = $result->fetch_all(
                MYSQLI_ASSOC
            );

            successResponse($events);
        }

        $conn->close();

        break;


    // =========================
    // POST
    // =========================
    case 'POST':

        $body = json_decode(
            file_get_contents("php://input"),
            true
        );

        $name = trim($body['name'] ?? '');

        $date = trim($body['date'] ?? '');

        $location = trim($body['location'] ?? '');

        $price = (int) ($body['price'] ?? 0);

        $desc = trim($body['description'] ?? '');

        if (!$name || !$date || !$location) {

            errorResponse(
                "name, date, dan location wajib diisi"
            );

            break;
        }

        $conn = getConnection();

        $stmt = $conn->prepare(
            "INSERT INTO events 
            (name, date, location, price, description)
            VALUES (?, ?, ?, ?, ?)"
        );

        $stmt->bind_param(
            "sssis",
            $name,
            $date,
            $location,
            $price,
            $desc
        );

        if ($stmt->execute()) {

            successResponse(
                ["id" => $conn->insert_id],
                "Event berhasil ditambahkan"
            );

        } else {

            errorResponse(
                "Gagal menambahkan event: " .
                $stmt->error,
                500
            );
        }

        $conn->close();

        break;


    // =========================
    // PUT
    // =========================
    case 'PUT':

        if (!$id) {

            errorResponse(
                "ID event diperlukan"
            );

            break;
        }

        $body = json_decode(
            file_get_contents("php://input"),
            true
        );

        $name = trim($body['name'] ?? '');

        $date = trim($body['date'] ?? '');

        $location = trim($body['location'] ?? '');

        $price = (int) ($body['price'] ?? 0);

        $desc = trim($body['description'] ?? '');

        $conn = getConnection();

        $stmt = $conn->prepare(
            "UPDATE events
             SET
                name = ?,
                date = ?,
                location = ?,
                price = ?,
                description = ?
             WHERE id = ?"
        );

        $stmt->bind_param(
            "sssisi",
            $name,
            $date,
            $location,
            $price,
            $desc,
            $id
        );

        if ($stmt->execute()) {

            successResponse(
                null,
                "Event berhasil diperbarui"
            );

        } else {

            errorResponse(
                "Gagal memperbarui event",
                500
            );
        }

        $conn->close();

        break;


    // =========================
    // DELETE
    // =========================
    case 'DELETE':

        if (!$id) {

            errorResponse(
                "ID event diperlukan"
            );

            break;
        }

        $conn = getConnection();

        $stmt = $conn->prepare(
            "DELETE FROM events WHERE id = ?"
        );

        $stmt->bind_param(
            "i",
            $id
        );

        if ($stmt->execute()) {

            successResponse(
                null,
                "Event berhasil dihapus"
            );

        } else {

            errorResponse(
                "Gagal menghapus event",
                500
            );
        }

        $conn->close();

        break;


    // =========================
    // DEFAULT
    // =========================
    default:

        errorResponse(
            "Method tidak diizinkan",
            405
        );
}