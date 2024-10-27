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

    Scenario: It returns all collectibles
        When I visit "/collectibles"
        Then the response is:
        """
            [
                {
                    "id": "baca94a4-a209-45e1-be33-d079248122ee",
                    "code": "B04-001SR",
                    "name": "Tsubasa Oribe: The Golden Idol",
                    "url": "https://wiki.serenesforest.net/index.php/"
                },
                {
                    "id": "f7651856-6f72-46e0-b8f2-eacc842568c5",
                    "code": "B04-001SR+",
                    "name": "Tsubasa Oribe: The Golden Idol",
                    "url": "https://wiki.serenesforest.net/index.php/"
                },
                {
                    "id": "2067fcd0-adf8-4838-be21-5ed3e77451a9",
                    "code": "B04-002N",
                    "name": "Tsubasa Oribe: All-Out Idol",
                    "url": "https://wiki.serenesforest.net/index.php/"
                },
                {
                    "id": "dba40add-905f-4ea6-946e-cc2382f122f2",
                    "code": "B04-003HN",
                    "name": "Tsubasa Oribe: Dreaming Schoolgirl",
                    "url": "https://wiki.serenesforest.net/index.php/"
                }
            ]
        """
