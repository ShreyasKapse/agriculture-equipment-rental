<?php
// frontend/pages/farmer/browse_equipment.php
require_once '../../../backend/config/db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Search and filter logic
$search = $_GET['search'] ?? '';
$category = $_GET['category'] ?? 'all';

$sql = "SELECT e.*, AVG(r.rating) as avg_rating, COUNT(r.id) as review_count 
        FROM equipment e
        LEFT JOIN bookings b ON e.id = b.equipment_id
        LEFT JOIN reviews r ON b.id = r.booking_id
        WHERE e.is_available = 1";
$params = [];

if ($search) {
    $sql .= " AND (e.name LIKE ? OR e.description LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

if ($category !== 'all') {
    $sql .= " AND e.category = ?";
    $params[] = $category;
}

$sql .= " GROUP BY e.id ORDER BY e.created_at DESC LIMIT 8";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$equipment_list = $stmt->fetchAll();

// Sample equipment data (in case database is empty)
$sample_equipment = [
    [
        'id' => 1,
        'name' => 'John Deere 5050D',
        'category' => 'tractors',
        'specs' => '50 HP • 2021 Model',
        'price_per_day' => 120,
        'image' => '/agriculture-equipment-rental/frontend/assets/images/john-deere-5050d.png',
        'available' => true
    ],
    [
        'id' => 2,
        'name' => 'Massey Ferguson 241',
        'category' => 'tractors',
        'specs' => '42 HP • 2020 Model',
        'price_per_day' => 95,
        'image' => '/agriculture-equipment-rental/frontend/assets/images/tractor-category.png',
        'available' => true
    ],
    [
        'id' => 3,
        'name' => 'New Holland Combine',
        'category' => 'harvesters',
        'specs' => 'High Capacity • 2022',
        'price_per_day' => 350,
        'image' => '/agriculture-equipment-rental/frontend/assets/images/new-holland-combine.png',
        'available' => true
    ],
    [
        'id' => 4,
        'name' => 'Kverneland Seeder',
        'category' => 'seeders',
        'specs' => 'Precision Drill • 6 Rows',
        'price_per_day' => 85,
        'image' => '/agriculture-equipment-rental/frontend/assets/images/kverneland-seeder.png',
        'available' => true
    ],
    [
        'id' => 5,
        'name' => 'Pivot Irrigation System',
        'category' => 'irrigation',
        'specs' => 'Mobile Unit • 500m Reach',
        'price_per_day' => 200,
        'image' => '/agriculture-equipment-rental/frontend/assets/images/pivot-irrigation.png',
        'available' => true
    ],
    [
        'id' => 6,
        'name' => 'Heavy Duty Trailer',
        'category' => 'trailers',
        'specs' => '10 Ton Capacity • Hydraulic',
        'price_per_day' => 60,
        'image' => '/agriculture-equipment-rental/frontend/assets/images/heavy-duty-trailer.png',
        'available' => true
    ],
    [
        'id' => 7,
        'name' => 'Mahindra JIVO',
        'category' => 'tractors',
        'specs' => 'Vineyard Specialist • 24 HP',
        'price_per_day' => 70,
        'image' => '/agriculture-equipment-rental/frontend/assets/images/mahindra-jivo.png',
        'available' => true
    ],
    [
        'id' => 8,
        'name' => 'Fendt 700 Vario',
        'category' => 'tractors',
        'specs' => 'Premium Tech • 140 HP',
        'price_per_day' => 250,
        'image' => '/agriculture-equipment-rental/frontend/assets/images/fendt-700-vario.png',
        'available' => true
    ]
];

// Use sample data if database is empty
if (empty($equipment_list)) {
    $equipment_list = $sample_equipment;

    // Apply category filter to sample data
    if ($category !== 'all') {
        $equipment_list = array_filter($equipment_list, function ($item) use ($category) {
            return $item['category'] === $category;
        });
    }

    // Apply search filter to sample data
    if ($search) {
        $equipment_list = array_filter($equipment_list, function ($item) use ($search) {
            return stripos($item['name'], $search) !== false ||
                stripos($item['specs'], $search) !== false;
        });
    }
}

require_once '../../includes/header.php';
?>

<style>
    .search-header {
        background: white;
        padding: 1.5rem 0;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        margin-bottom: 2rem;
    }

    .search-bar {
        max-width: 600px;
        margin: 0 auto;
        position: relative;
    }

    .search-bar input {
        padding-left: 3rem;
        border-radius: 50px;
        border: 2px solid #E0E0E0;
        padding-right: 1.5rem;
    }

    .search-bar input:focus {
        border-color: #2E7D32;
        box-shadow: 0 0 0 4px rgba(46, 125, 50, 0.1);
    }

    .search-icon {
        position: absolute;
        left: 1.2rem;
        top: 50%;
        transform: translateY(-50%);
        color: #757575;
        z-index: 10;
    }

    .filter-section {
        margin-bottom: 2rem;
    }

    .filter-buttons {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
        justify-content: center;
    }

    .filter-btn {
        padding: 0.75rem 1.5rem;
        border: 2px solid #E0E0E0;
        background: white;
        border-radius: 50px;
        font-weight: 600;
        color: #212121;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .filter-btn:hover {
        border-color: #2E7D32;
        background: #F1F8E9;
        color: #2E7D32;
    }

    .filter-btn.active {
        background: linear-gradient(135deg, #2E7D32, #66BB6A);
        border-color: #2E7D32;
        color: white;
    }

    .filter-btn svg {
        width: 20px;
        height: 20px;
        fill: currentColor;
    }

    .equipment-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 2rem;
        margin-bottom: 3rem;
    }

    .equipment-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        border: 2px solid transparent;
        position: relative;
    }

    .equipment-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 32px rgba(46, 125, 50, 0.15);
        border-color: #2E7D32;
    }

    .equipment-image {
        width: 100%;
        height: 220px;
        object-fit: cover;
    }

    .equipment-badge {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: #4CAF50;
        color: white;
        padding: 0.4rem 0.8rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        box-shadow: 0 2px 8px rgba(76, 175, 80, 0.4);
    }

    .equipment-content {
        padding: 1.5rem;
    }

    .equipment-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #212121;
        margin-bottom: 0.5rem;
    }

    .equipment-specs {
        color: #757575;
        font-size: 0.95rem;
        margin-bottom: 1rem;
    }

    .equipment-price {
        display: flex;
        align-items: baseline;
        gap: 0.25rem;
        margin-bottom: 1rem;
    }

    .price-amount {
        font-size: 1.75rem;
        font-weight: 800;
        color: #2E7D32;
    }

    .price-period {
        color: #757575;
        font-size: 0.9rem;
    }

    .book-btn {
        width: 100%;
        padding: 0.75rem;
        background: linear-gradient(135deg, #2E7D32, #66BB6A);
        border: none;
        color: white;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .book-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(46, 125, 50, 0.3);
    }

    .book-btn-outline {
        background: white;
        border: 2px solid #2E7D32;
        color: #2E7D32;
    }

    .book-btn-outline:hover {
        background: #2E7D32;
        color: white;
    }

    .show-more-section {
        text-align: center;
        padding: 2rem 0;
    }

    .show-more-btn {
        padding: 1rem 3rem;
        background: white;
        border: 2px solid #2E7D32;
        color: #2E7D32;
        border-radius: 50px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .show-more-btn:hover {
        background: #2E7D32;
        color: white;
        transform: translateY(-2px);
    }

    @media (max-width: 768px) {
        .equipment-grid {
            grid-template-columns: 1fr;
        }

        .filter-buttons {
            justify-content: flex-start;
        }
    }
</style>

<!-- Search Header -->
<div class="search-header">
    <div class="container">
        <form action="" method="GET">
            <div class="search-bar">
                <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                    fill="currentColor">
                    <path
                        d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z" />
                </svg>
                <input type="text" name="search" class="form-control" placeholder="Search equipment..."
                    value="<?php echo htmlspecialchars($search); ?>">
                <input type="hidden" name="category" value="<?php echo htmlspecialchars($category); ?>">
            </div>
        </form>
    </div>
</div>

<div class="container">
    <!-- Page Header -->
    <div class="text-center mb-4">
        <h1 class="display-5 fw-bold mb-2">Find Equipment</h1>
        <p class="text-muted">Browse and rent high-quality agricultural machinery for your farm.</p>
    </div>

    <!-- Category Filters -->
    <div class="filter-section">
        <div class="filter-buttons">
            <a href="?category=all<?php echo $search ? '&search=' . urlencode($search) : ''; ?>"
                class="filter-btn <?php echo $category === 'all' ? 'active' : ''; ?>">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path d="M3 13h2v-2H3v2zm0 4h2v-2H3v2zm0-8h2V7H3v2zm4 4h14v-2H7v2zm0 4h14v-2H7v2zM7 7v2h14V7H7z" />
                </svg>
                All
            </a>
            <a href="?category=tractors<?php echo $search ? '&search=' . urlencode($search) : ''; ?>"
                class="filter-btn <?php echo $category === 'tractors' ? 'active' : ''; ?>">
                Tractors
            </a>
            <a href="?category=harvesters<?php echo $search ? '&search=' . urlencode($search) : ''; ?>"
                class="filter-btn <?php echo $category === 'harvesters' ? 'active' : ''; ?>">
                Harvesters
            </a>
            <a href="?category=seeders<?php echo $search ? '&search=' . urlencode($search) : ''; ?>"
                class="filter-btn <?php echo $category === 'seeders' ? 'active' : ''; ?>">
                Seeders
            </a>
            <a href="?category=irrigation<?php echo $search ? '&search=' . urlencode($search) : ''; ?>"
                class="filter-btn <?php echo $category === 'irrigation' ? 'active' : ''; ?>">
                Irrigation
            </a>
            <a href="?category=trailers<?php echo $search ? '&search=' . urlencode($search) : ''; ?>"
                class="filter-btn <?php echo $category === 'trailers' ? 'active' : ''; ?>">
                Trailers
            </a>
        </div>
    </div>

    <!-- Equipment Grid -->
    <div class="equipment-grid">
        <?php if (count($equipment_list) > 0): ?>
            <?php foreach ($equipment_list as $item): ?>
                <div class="equipment-card">
                    <?php
                    $image_url = isset($item['image']) ? $item['image'] :
                        (isset($item['image_url']) ? '/agriculture-equipment-rental/' . $item['image_url'] :
                            '/agriculture-equipment-rental/frontend/assets/images/tractor-category.png');
                    ?>
                    <img src="<?php echo htmlspecialchars($image_url); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>"
                        class="equipment-image">

                    <?php if (isset($item['available']) ? $item['available'] : $item['is_available']): ?>
                        <div class="equipment-badge">Available</div>
                    <?php endif; ?>

                    <div class="equipment-content">
                        <h3 class="equipment-title"><?php echo htmlspecialchars($item['name']); ?></h3>
                        <p class="equipment-specs">
                            <?php echo htmlspecialchars(isset($item['specs']) ? $item['specs'] :
                                (isset($item['description']) ? substr($item['description'], 0, 50) . '...' : 'Agricultural Equipment')); ?>
                        </p>
                        <div class="equipment-price">
                            <span class="price-amount">₹<?php echo number_format($item['price_per_day'], 0); ?></span>
                            <span class="price-period">/day</span>
                        </div>

                        <?php if (isset($item['avg_rating']) && $item['avg_rating'] > 0): ?>
                            <div class="mb-3 text-warning small">
                                <?php echo str_repeat('★', round($item['avg_rating'])); ?>
                                <?php echo str_repeat('☆', 5 - round($item['avg_rating'])); ?>
                                <span class="text-muted ms-1">(<?php echo $item['review_count']; ?>)</span>
                            </div>
                        <?php else: ?>
                            <div class="mb-3 text-muted small">No reviews yet</div>
                        <?php endif; ?>

                        <?php if (isset($_SESSION['user_id']) && $_SESSION['user_role'] === 'farmer'): ?>
                            <a href="book_equipment.php?id=<?php echo $item['id']; ?>" class="book-btn">Book Now</a>
                        <?php elseif (!isset($_SESSION['user_id'])): ?>
                            <a href="../auth/login.php" class="book-btn book-btn-outline">Login to Book</a>
                        <?php else: ?>
                            <button class="book-btn" style="background: #9E9E9E; cursor: not-allowed;" disabled>Owner View
                                Only</button>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center py-5">
                <p class="text-muted">No equipment found matching your criteria.</p>
                <a href="?" class="btn btn-primary mt-3">View All Equipment</a>
            </div>
        <?php endif; ?>
    </div>

    <!-- Show More Button -->
    <?php if (count($equipment_list) >= 8): ?>
        <div class="show-more-section">
            <button class="show-more-btn" onclick="alert('Load more functionality coming soon!')">
                Show More Equipment
            </button>
        </div>
    <?php endif; ?>
</div>

<?php require_once '../../includes/footer.php'; ?>