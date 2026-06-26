-- ============================================================
-- SAFE OPTION: Only update photo_url (table already exists on live)
-- Run this if you already have testimonials rows and only
-- need to link new images — does NOT drop the table.
-- ============================================================

UPDATE testimonials SET photo_url = 'review-img/mani-sinha.png' WHERE name = 'Mani Sinha';
UPDATE testimonials SET photo_url = 'review-img/prashant-kumar.png' WHERE name = 'Prashant Kumar';
UPDATE testimonials SET photo_url = 'review-img/debashish-maji.png' WHERE name = 'Debashish Maji';
UPDATE testimonials SET photo_url = 'review-img/rakesh-pandey.png' WHERE name = 'Rakesh Pandey';
UPDATE testimonials SET photo_url = 'review-img/tarika.png' WHERE name = 'Tarika Nigam';
UPDATE testimonials SET photo_url = 'review-img/shubham-mer.png' WHERE name = 'Shubham Mer';
UPDATE testimonials SET photo_url = 'review-img/priyanka-tisoria.png' WHERE name = 'Priyanka Tisoria';
UPDATE testimonials SET photo_url = 'review-img/mayank-bhatia.png' WHERE name = 'Mayank Bhatia';
UPDATE testimonials SET photo_url = 'review-img/ravi-singh.png' WHERE name = 'Ravi Singh';
UPDATE testimonials SET photo_url = 'review-img/subhadip.png' WHERE name = 'Subhadip';
UPDATE testimonials SET photo_url = 'review-img/shubham-pandey.png' WHERE name = 'Shubham Pandey';
UPDATE testimonials SET photo_url = 'review-img/prikshit.png' WHERE name = 'Prikshit Awasthi';
