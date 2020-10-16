<?php

namespace Database\Seeders;

use App\Models\Gift;
use Illuminate\Database\Seeder;

class GiftsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Gift::create([
            'category_id' => 25,
            'sub_category_id' => 38,
            'gift_name' => 'customizable mug',
            'slug' => 'customizable-mug',
            'gift_image' => '15f458254a0dac.1.jpg',
            'usd_price' => 3.99,
            'zar_price' => 65.84,
            'zwl_price' => 399.00,
            'description' => 'Express your love for your family and friends by giving them this customizable mug that you can print anything you want. It&#39;s in all colors.',
            'units' => 250,
            'label' => 'customizable'
        ]);

        Gift::create([
            'category_id' => 9,
            'sub_category_id' => 107,
            'gift_name' => 'Plastic Bowls & Plates',
            'slug' => 'plastic-plates-and-bowls',
            'gift_image' => '15f45876d2ff63.jpg',
            'usd_price' => 24.99,
            'zar_price' => 412.34,
            'zwl_price' => 2499.00,
            'description' => 'STYLISH DESIGN: soft matte glaze stoneware featuring an off-white edge along the rim great making Rockaway great for all occasions.\r\nWHAT’S IN THE BOX: Service for 4 that includes 4 of each of the following: 10.5” Dinner Plates, 8” Dessert Plates, 6” (26.5 OZ) Bowls.\r\nMATTE GLAZE: a smooth, flat finish dipped in beautiful solid color creates a sleek and artistic addition to the table.\r\nFAMILY OWNED: Gibson Overseas, Inc. is an industry-leading producer of tabletop and housewares products based in Los Angeles, California. Family-owned for over 40 years, we’ve developed a portfolio that thrives off relentless commitment to style, innovation, and value for our consumers around the world.\r\nROCKAWAY: a modern simplicity that brings style into every kitchen. These plates will make a statement. The coupe-shaped edges allow for a stackable and space saving benefit.\r\nCARE INSTRUCTIONS: a beautiful set that is also microwave and dishwasher safe. ',
            'units' => 100,
            'label' => 'new'
        ]);

        Gift::create([
            'category_id' => 21,
            'sub_category_id' => 123,
            'gift_name' => 'Crate Washing Basket',
            'slug' => 'washing-basket',
            'gift_image' => '15f45885de939d.jpg',
            'usd_price' => 8.99,
            'zar_price' => 148.34,
            'zwl_price' => 899.00,
            'description' => 'Collect your dirty laundry in these durable and classy crate plastic washing baskets.',
            'units' => 20,
            'label' => 'new'
        ]);

        Gift::create([
            'category_id' => 9,
            'sub_category_id' => 107,
            'gift_name' => 'Plastic Plates & Bowls',
            'slug' => 'plates-and-bowls',
            'gift_image' => '15f458474b905f.jpg',
            'usd_price' => 19.99,
            'zar_price' => 329.84,
            'zwl_price' => 1999.00,
            'description' => 'Enjoy your cereals in these durable plastic bowls. For meals the plastic plates have you covered.  Microwave safe\r\nTop rack dishwasher safe\r\nBPA free\r\nMade in the USA\r\n4-Tumblers, 4 -plates, 4 -small bowls, & 1- serving bowl',
            'units' => 50,
            'label' => 'new'
        ]);
        
        Gift::create([
            'category_id' => 9,
            'sub_category_id' => 108,
            'gift_name' => 'Non-sticky cooking set',
            'slug' => 'non-sticky-cooking-set',
            'gift_image' => '15f4589a272d30.jpg',
            'usd_price' => 29.99,
            'zar_price' => 494.84,
            'zwl_price' => 2999.00,
            'description' => ' Hard anodized exterior: Harder than stainless steel; dense, nonporous, and highly wear resistant for extra durability and professional performance\r\nQuantanium nonstick interior; premium nonstick surfACe reinforced with titanium provides lasting food release; no oil or butter needed for healthier low fat cooking options, and easy cleanup\r\nThe 10 inch skillet comes with break resistant glass covers allow you to monitor food while it is cooking and rims are tapered for drip free pouring\r\nOven safe to 500 degree f; glass lids are oven safe to 350 degree f; cook in oven or on stove top\r\nSet includes: 1 quart saucepan, 2 quarts saucepan, 3 quarts saucepan, 3 quarts sauté pan w/helper, 8 quarts stockpot, all with covers; an 8 inch open skillet, 10 inch covered skillet and an 18 centimeter multi steamer insert',
            'units' => 50,
            'label' => 'new'
        ]);

        Gift::create([
            'category_id' => 8,
            'sub_category_id' => 171,
            'gift_name' => 'cosori electric jug',
            'slug' => 'electric-jug',
            'gift_image' => '679871579.jpg',
            'usd_price' => 24.99,
            'zar_price' => 412.34,
            'zwl_price' => 2499.00,
            'description' => ' Plastic-Free Filter: Cosori\'s upgraded electric kettle was designed with a 100% stainless steel filter, It also has high-quality borosilicate glass that\'s printed with liter and cup tick marks, and resists scratching and scuffing\r\nRapid Boil: The water rapidly boils within 3–7 minutes, so it\'s a great choice to replace your microwave, stove, or old kettle. It\'s the perfect appliance for coffee, tea, oatmeal, and pasta\r\nSafe Tech & Auto Shut off: Features British Strix thermostat technology and auto shutoff within 30 seconds of the water fully boiling. The boil-dry safety feature turns off the kettle if it detects no water inside\r\nBlue LED Indicator: The blue indicator lights up while the kettle is boiling and shuts off to let you know when your water is ready\r\nPerfect Addition: Its minimalist design and soft blue indicator light make it the perfect addition to your kitchen. It\'s completely cordless when it\'s off the base and rotates 360o for convenient pouring and serving ',
            'units' => 100,
            'label' => 'new'
        ]);

        Gift::create([
            'category_id' => 22,
            'sub_category_id' => 79,
            'gift_name' => 'Quilted Comforter',
            'slug' => 'comforter',
            'gift_image' => '15f4598bf99479.jpg',
            'usd_price' => 35.99,
            'zar_price' => 593.84,
            'zwl_price' => 3599.00,
            'description' => 'Ultra-soft, all-season microfiber comforter with 8 built-in corner and side loops to secure your favorite duvet cover\n    Microfiber down alternative fill has a 300 gsm fill weight; Provides the cozy comfort of down without the feathers, odor, and sharp quills\n    Reversible color design is like two comforters in one to easily match your decor and mood\n    Box stitch design keeps the fill in place, so comforter maintains a recently fluffed look; Backed by a 3-year warranty\n    Machine wash comforter in cold water on a gentle cycle, then air dry or tumble dry on low to maintain quality, freshness, and comfort; Queen size measures 88&#34; x 92&#34;\n',
            'units' => 30,
            'label' => 'new'
        ]);

        Gift::create([
            'category_id' => 25,
            'sub_category_id' => 39,
            'gift_name' => 'Customized Plastic Keyholders',
            'slug' => 'keyholders',
            'gift_image' => '15f459ecd42a91.jpg',
            'usd_price' => 8.99,
            'zar_price' => 148.34,
            'zwl_price' => 899.00,
            'description' => 'Customize your keyholder by having your name printed in our magical plastic kyeholders',
            'units' => 50,
            'label' => 'customizable'
        ]);
    }
}
