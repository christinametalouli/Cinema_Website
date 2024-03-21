package com.cinema.dao;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Timestamp;
import java.util.ArrayList;
import java.util.List;

import com.cinema.db.CinemaDb;
import com.cinema.model.Booking;

public class BookingDao {

    private Connection connection;

    public BookingDao() throws ClassNotFoundException, SQLException {
        this.connection = CinemaDb.getConnection();
    }

    public void createBooking(Booking booking) throws SQLException {
        String query = "INSERT INTO bookings (user_id, movie_id, email, booking_date) VALUES (?, ?, ?, ?)";
        PreparedStatement statement = connection.prepareStatement(query);
        statement.setInt(1, booking.getUserId());
        statement.setInt(2, booking.getMovieId());
        statement.setString(3, booking.getEmail());
        statement.setTimestamp(4, new Timestamp(booking.getBookingDate().getTime()));
        statement.executeUpdate();
    }

    public List<Booking> getBookingsByUserId(int userId) throws SQLException {
        String query = "SELECT * FROM bookings WHERE user_id = ?";
        PreparedStatement statement = connection.prepareStatement(query);
        statement.setInt(1, userId);
        ResultSet resultSet = statement.executeQuery();
        List<Booking> bookings = new ArrayList<>();
        while (resultSet.next()) {
            Booking booking = new Booking(
                    resultSet.getInt("booking_id"),
                    resultSet.getInt("user_id"),
                    resultSet.getInt("movie_id"),
                    resultSet.getString("email"),
                    resultSet.getTimestamp("booking_date"));
            bookings.add(booking);
        }
        return bookings;
    }

    public void deleteBooking(int bookingId) throws SQLException {
        String query = "DELETE FROM bookings WHERE booking_id = ?";
        PreparedStatement statement = connection.prepareStatement(query);
        statement.setInt(1, bookingId);
        statement.executeUpdate();
    }
}
