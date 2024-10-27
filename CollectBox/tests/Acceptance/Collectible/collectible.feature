Feature: Collectible context check
    Scenario: It returns a collectible when found
        When I visit "/collectibles/baca94a4-a209-45e1-be33-d079248122ee"
        Then the response is:
        """
            {
                "id": "baca94a4-a209-45e1-be33-d079248122ee",
                "code": "B04-001SR",
                "name": "Tsubasa Oribe: The Golden Idol",
                "url": "https://wiki.serenesforest.net/index.php/"
            }
        """
    
    Scenario: It returns a 404 when the collectible is not found
        When I visit "/collectibles/baca94a4-a209-45e1-be33-d079248122ea"
        Then 404 is returned 

