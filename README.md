# CQRS - ES - Broadway sample
Cqrs Es with Broadway

# Commands:
- bin/console doctrine:migrations:migrate

#Applying Broadway
  - Event Domain
    - Create Event Domain class (UserWasCreated)
    - Class implements Broadway\Serializer\Serializable
    - Add 2 methods: 
      - Serialize => return array
      - Deserialize => return Event Domain object
  - Model:
    - Add "getAggregateRootId" method with Aggregate Root Id
    - Add a "Create" factory function 
      - Call "apply" function with instance of Event Domain filled
    - Add "applyNameEventDomain" and get information from Event Domain and fill object with data
  - Migration:
    - Add a new migration to create EVENT Version20180102233829.php