package com.cinema.dao;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.List;

import com.cinema.db.CinemaDb;
import com.cinema.model.RegistrationRequest;

public class RegistrationRequestDao {

    private Connection conn;

    public RegistrationRequestDao() throws ClassNotFoundException, SQLException {
        this.conn = CinemaDb.getConnection();
    }

    public void create(RegistrationRequest request) throws SQLException {
        String query = "INSERT INTO registration_requests (first_name, last_name, country, city, address, email, username, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        PreparedStatement stmt = conn.prepareStatement(query);
        stmt.setString(1, request.getFirstName());
        stmt.setString(2, request.getLastName());
        stmt.setString(3, request.getCountry());
        stmt.setString(4, request.getCity());
        stmt.setString(5, request.getAddress());
        stmt.setString(6, request.getEmail());
        stmt.setString(7, request.getUsername());
        stmt.setString(8, request.getPassword());

        stmt.executeUpdate();
    }

    public RegistrationRequest findById(int id) throws SQLException {
        String query = "SELECT * FROM registration_requests WHERE request_id = ?";
        PreparedStatement stmt = conn.prepareStatement(query);
        stmt.setInt(1, id);

        ResultSet rs = stmt.executeQuery();
        if (!rs.next()) {
            return null;
        }

        RegistrationRequest request = new RegistrationRequest(
                rs.getInt("request_id"),
                rs.getString("first_name"),
                rs.getString("last_name"),
                rs.getString("country"),
                rs.getString("city"),
                rs.getString("address"),
                rs.getString("email"),
                rs.getString("username"),
                rs.getString("password"),
                rs.getString("status")
        );

        return request;
    }

    public List<RegistrationRequest> getAllRequests() throws SQLException {
        String query = "SELECT * FROM registration_requests";
        PreparedStatement stmt = conn.prepareStatement(query);

        ResultSet rs = stmt.executeQuery();

        List<RegistrationRequest> requests = new ArrayList<>();

        while (rs.next()) {
            RegistrationRequest request = new RegistrationRequest(
                    rs.getInt("request_id"),
                    rs.getString("first_name"),
                    rs.getString("last_name"),
                    rs.getString("country"),
                    rs.getString("city"),
                    rs.getString("address"),
                    rs.getString("email"),
                    rs.getString("username"),
                    rs.getString("password"),
                    rs.getString("status")
            );

            requests.add(request);
        }

        return requests;
    }
    
    public void deleteRegistrationRequest(int requestId) throws SQLException {
        String sql = "DELETE FROM registration_requests WHERE request_id = ?";
        try (PreparedStatement stmt = conn.prepareStatement(sql)) {
            stmt.setInt(1, requestId);
            stmt.executeUpdate();
        } catch (SQLException e) {
            throw e;
        }
    }

}

