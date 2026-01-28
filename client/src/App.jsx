import { BrowserRouter, Routes, Route } from "react-router-dom";
import AdminLayout from "./layout/Admin_layout.jsx";
import TourList from "./pages/Admin/Tour/List.jsx";
import TourForm from "./pages/Admin/Tour/Create.jsx";
import CategoryList from "./pages/Admin/CategoriesTour/List.jsx";
import AddCategory from "./pages/Admin/CategoriesTour/Create.jsx";
import EditCategory from "./pages/Admin/CategoriesTour/Edit.jsx";
import EditTour from "./pages/Admin/Tour/Edit.jsx";
import GuideLogin from "./pages/Guide/Login.jsx";
import GuideLayout from "./layout/Guide_layout.jsx";
import GuideDashboard from "./pages/Guide/Dashboard.jsx";
import GuideBookings from "./pages/Guide/Bookings.jsx";
import GuideTours from "./pages/Guide/Tours.jsx";
import GuideProfile from "./pages/Guide/Profile.jsx";

function App() {
  return (
    <BrowserRouter>
      <Routes>
        <Route path="/admin" element={<AdminLayout />}>
          <Route path="categories" element={<CategoryList />} />
          <Route path="categories/add" element={<AddCategory />} />
          <Route path="categories/edit/:id" element={<EditCategory />} />
          <Route path="tours" element={<TourList />} />
          <Route path="tours/add" element={<TourForm />} />
          <Route path="tours/edit/:id" element={<EditTour />} />

        </Route>
        {/* Route cho Guide */}
        <Route path="/guide" element={<GuideLayout />}>
          <Route index element={<GuideDashboard />} />
          <Route path="bookings" element={<GuideBookings />} />
          <Route path="tours" element={<GuideTours />} />
          <Route path="profile" element={<GuideProfile />} />
        </Route>
        <Route path="/guide/login" element={<GuideLogin />} />
      </Routes>
    </BrowserRouter>
  );
}

export default App;
